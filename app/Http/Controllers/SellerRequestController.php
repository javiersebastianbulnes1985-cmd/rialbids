<?php

namespace App\Http\Controllers;

use App\Models\SellerRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class SellerRequestController extends Controller
{
    public function create()
    {
        return view('seller-request.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|max:255',
            'password'   => 'required|string|min:8|confirmed',
            'country'    => 'required|string|max:100',
            'what_sells' => 'required|string|max:1000',
        ]);

        // Verificar si ya tiene cuenta
        $user = User::where('email', $request->email)->first();

        if ($user && $user->role === 'seller') {
            return back()->with('error', 'Ya tenes una cuenta de vendedor activa. Inicia sesion en /login.');
        }

        // Crear o actualizar usuario con la contrasena elegida por el usuario
        if (!$user) {
            $user = User::create([
                'name'              => $request->name,
                'email'             => $request->email,
                'password'          => Hash::make($request->password),
                'role'              => 'seller',
                'email_verified_at' => now(),
                'is_active'         => true,
            ]);
        } else {
            // Usuario existente (ej. era comprador): lo pasamos a seller y actualizamos su clave
            $user->role = 'seller';
            $user->password = Hash::make($request->password);
            $user->save();
        }

        // Guardar solicitud
        SellerRequest::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'country'    => $request->country,
            'what_sells' => $request->what_sells,
            'status'     => 'approved',
            'user_id'    => $user->id,
        ]);

        // Email de bienvenida (ya sin contrasena: el usuario la eligio el mismo)
        $user->notify(new \App\Notifications\BienvenidaVendor(null));

        // Login automatico: el usuario entra directo, sin pasar por el email
        Auth::login($user);

        return redirect('/dashboard')->with('success', 'Cuenta de vendedor activada! Ya podes publicar tu primer lote.')->with('vendor_registered', true);
    }
}
