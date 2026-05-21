<?php

namespace App\Http\Controllers;

use App\Models\SellerRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
            'country'    => 'required|string|max:100',
            'what_sells' => 'required|string|max:1000',
        ]);

        $europeanCountries = ['España','Francia','Italia','Alemania','Portugal','Países Bajos','Bélgica','Suecia','Polonia','Austria','Suiza','Dinamarca','Noruega','Finlandia','Grecia','República Checa','Hungría','Rumanía','Bulgaria','Croacia','Eslovaquia','Eslovenia','Estonia','Letonia','Lituania','Luxemburgo','Malta','Chipre','Irlanda'];

        // Verificar si ya tiene cuenta
        $user = User::where('email', $request->email)->first();

        if ($user && $user->role === 'seller') {
            return back()->with('error', 'Ya tenés una cuenta de vendedor activa.');
        }

        // Crear o actualizar usuario
        if (!$user) {
            $password = \Illuminate\Support\Str::random(10);
            $user = User::create([
                'name'              => $request->name,
                'email'             => $request->email,
                'password'          => Hash::make($password),
                'role'              => 'seller',
                'email_verified_at' => now(),
                'is_active'         => true,
            ]);
        } else {
            $user->role = 'seller';
            $user->save();
            $password = null;
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

        // Email al vendedor
        $emailContent = "Hola {$request->name},\n\nTu cuenta de vendedor en RialBids fue activada.\n\n";
        if ($password) {
            $emailContent .= "Tus credenciales:\nEmail: {$request->email}\nContraseña: {$password}\n\n";
        }
        $emailContent .= "Accedé a tu panel en: https://rialbids.com/vendor\n\nEl equipo de RialBids";

        Mail::raw($emailContent, function($m) use ($request) {
            $m->to($request->email)->subject('Tu cuenta de vendedor en RialBids está activa');
        });

        return redirect('/como-vender')->with('success', '¡Cuenta de vendedor activada! Revisá tu email.');
    }
}
