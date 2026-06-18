<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Auction;
use App\Models\Dispute;
use App\Models\User;
use App\Notifications\DisputaAbierta;
use Illuminate\Support\Facades\Notification;

class DisputeController extends Controller
{
    public function create(Auction $auction)
    {
        $user = auth()->user();
        abort_unless($user, 403);

        if ((int) $auction->winner_id !== (int) $user->id) {
            abort(403, 'Solo el ganador del lote puede abrir una disputa.');
        }

        $existing = Dispute::where('auction_id', $auction->id)
            ->where('buyer_id', $user->id)
            ->whereIn('status', ['abierta', 'en_revision'])
            ->first();

        return view('disputes.create', compact('auction', 'existing'));
    }

    public function store(Request $request, Auction $auction)
    {
        $user = auth()->user();
        abort_unless($user, 403);

        if ((int) $auction->winner_id !== (int) $user->id) {
            abort(403, 'Solo el ganador del lote puede abrir una disputa.');
        }

        $data = $request->validate([
            'reason'      => 'required|string|max:120',
            'description' => 'required|string|max:2000',
            'photo'       => 'nullable|image|max:5120',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('disputes', 'public');
        }

        $dispute = Dispute::create([
            'auction_id'  => $auction->id,
            'buyer_id'    => $user->id,
            'seller_id'   => $auction->user_id,
            'reason'      => $data['reason'],
            'description' => $data['description'],
            'photo_path'  => $photoPath,
            'status'      => 'abierta',
        ]);

        $auction->dispute_status = 'abierta';
        $auction->disputed_at    = now();
        $auction->save();

        Notification::route('mail', 'javiersebastianbulnes1985@gmail.com')
            ->notify(new DisputaAbierta($dispute));
        Notification::route('mail', 'info@rialbids.com')
            ->notify(new DisputaAbierta($dispute));

        // Avisar al vendedor para que pueda dar su version
        try {
            if ($auction->user) {
                $auction->user->notify(new \App\Notifications\DisputaAbiertaVendedor($dispute));
            }
        } catch (\Exception $e) {
            \Log::error('Error avisando al vendedor de disputa #' . $dispute->id . ': ' . $e->getMessage());
        }

        return redirect()->route('profile.index')->with('success', 'Tu disputa fue abierta. Te contactaremos pronto.');
    }

    // ===== RESOLUCION DE DISPUTAS (ADMIN) =====

    public function resolver(Request $request, Dispute $dispute)
    {
        abort_unless(auth()->user() && auth()->user()->isAdmin(), 403);

        $accion = $request->input('accion');
        $auction = $dispute->auction;

        if ($accion === 'revision') {
            $dispute->update(['status' => 'en_revision']);
            if ($auction) { $auction->update(['dispute_status' => 'en_revision']); }
            return back()->with('success', 'Disputa marcada en revision.');
        }

        if ($accion === 'vendedor') {
            $ok = \App\Http\Controllers\StripeConnectController::liberarPago($auction);
            $dispute->update(['status' => 'resuelta_vendedor', 'admin_resolution' => $request->input('nota'), 'resolved_at' => now()]);
            if ($auction) { $auction->update(['dispute_status' => 'resuelta_vendedor']); }
            $this->notificarResolucion($dispute, 'vendedor');
            $msg = $ok ? 'Disputa resuelta a favor del vendedor. Pago liberado.' : 'Resuelta a favor del vendedor. ATENCION: el pago no se libero automatico (vendedor sin Stripe). Revisa Stripe.';
            return back()->with($ok ? 'success' : 'error', $msg);
        }

        if ($accion === 'comprador') {
            \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
            $refundOk = false;
            try {
                $charges = \Stripe\Charge::search(['query' => "metadata['auction_id']:'" . $auction->id . "'"]);
                if (!empty($charges->data)) {
                    \Stripe\Refund::create(['charge' => $charges->data[0]->id, 'reverse_transfer' => true]);
                    $refundOk = true;
                }
            } catch (\Exception $e) {
                \Log::error('Error reembolso disputa #' . $dispute->id . ': ' . $e->getMessage());
            }
            $dispute->update(['status' => 'resuelta_comprador', 'admin_resolution' => $request->input('nota'), 'resolved_at' => now()]);
            if ($auction) { $auction->update(['dispute_status' => 'resuelta_comprador', 'status' => 'cancelled']); }
            $this->notificarResolucion($dispute, 'comprador');
            $msg = $refundOk ? 'Disputa resuelta a favor del comprador. Reembolso procesado en Stripe.' : 'Marcada a favor del comprador. ATENCION: el reembolso no se proceso automatico. Revisa Stripe manualmente.';
            return back()->with($refundOk ? 'success' : 'error', $msg);
        }

        return back()->with('error', 'Accion no valida.');
    }

    private function notificarResolucion(Dispute $dispute, string $favor): void
    {
        try {
            if ($dispute->buyer) {
                $dispute->buyer->notify(new \App\Notifications\ResolucionDisputa($dispute, $favor, 'comprador'));
            }
            if ($dispute->seller) {
                $dispute->seller->notify(new \App\Notifications\ResolucionDisputa($dispute, $favor, 'vendedor'));
            }
        } catch (\Exception $e) {
            \Log::error('Error notificando resolucion disputa #' . $dispute->id . ': ' . $e->getMessage());
        }
    }

    public function responderVendedor(Request $request, Dispute $dispute)
    {
        abort_unless(auth()->id() === $dispute->seller_id, 403);

        $data = $request->validate([
            'seller_response' => 'required|string|max:2000',
        ]);

        $dispute->seller_response = $data['seller_response'];
        $dispute->seller_responded_at = now();
        $dispute->save();

        try {
            \Illuminate\Support\Facades\Mail::raw(
                "El vendedor respondio a la disputa #{$dispute->id}.\n\nSu version:\n{$data['seller_response']}\n\nRevisa /admin/pagos para resolver.",
                function ($m) {
                    $m->to('javiersebastianbulnes1985@gmail.com')->subject('Vendedor respondio una disputa - RialBids');
                }
            );
        } catch (\Exception $e) {
            \Log::error('Error avisando respuesta vendedor disputa #' . $dispute->id . ': ' . $e->getMessage());
        }

        return back()->with('success', 'Tu respuesta fue enviada. La revisaremos para resolver la disputa.');
    }
}
