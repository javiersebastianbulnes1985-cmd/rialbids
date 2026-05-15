<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ── ADMIN ─────────────────────────────────────────────────────────────
        User::create([
            'role'                      => 'admin',
            'name'                      => 'Admin RialBids',
            'email'                     => 'admin@rialbids.com',
            'password'                  => Hash::make('Admin1234!'),
            'email_verified_at'         => now(),
            'kyc_status'                => 'approved',
            'is_active'                 => true,
            'country'                   => 'España',
            'city'                      => 'Madrid',
        ]);

        // ── SELLERS ───────────────────────────────────────────────────────────
        User::create([
            'role'                      => 'seller',
            'name'                      => 'María González',
            'email'                     => 'seller1@rialbids.com',
            'password'                  => Hash::make('Seller1234!'),
            'email_verified_at'         => now(),
            'kyc_status'                => 'approved',
            'kyc_verified_at'           => now(),
            'is_active'                 => true,
            'business_name'             => 'Joyería González Madrid',
            'bio'                       => 'Joyería familiar con más de 30 años de experiencia en joyería fina y piezas de colección. Especializados en oro 18k y diamantes certificados.',
            'phone'                     => '+34 911 234 567',
            'address'                   => 'Calle Serrano 45',
            'city'                      => 'Madrid',
            'state'                     => 'Comunidad de Madrid',
            'country'                   => 'España',
            'postal_code'               => '28001',
            'website'                   => 'https://joyeriagonzalez.es',
            'stripe_onboarding_complete' => false,
            'is_featured_seller'        => true,
        ]);

        User::create([
            'role'                      => 'seller',
            'name'                      => 'Roberto Ferreira',
            'email'                     => 'seller2@rialbids.com',
            'password'                  => Hash::make('Seller1234!'),
            'email_verified_at'         => now(),
            'kyc_status'                => 'approved',
            'kyc_verified_at'           => now(),
            'is_active'                 => true,
            'business_name'             => 'Galería Arte Contemporáneo BCN',
            'bio'                       => 'Galería especializada en arte contemporáneo español e internacional. Representamos a artistas emergentes y consolidados.',
            'phone'                     => '+34 932 456 789',
            'address'                   => 'Passeig de Gràcia 78',
            'city'                      => 'Barcelona',
            'state'                     => 'Cataluña',
            'country'                   => 'España',
            'postal_code'               => '08008',
            'stripe_onboarding_complete' => false,
            'is_featured_seller'        => true,
        ]);

        User::create([
            'role'                      => 'seller',
            'name'                      => 'Sophie Dubois',
            'email'                     => 'seller3@rialbids.com',
            'password'                  => Hash::make('Seller1234!'),
            'email_verified_at'         => now(),
            'kyc_status'                => 'approved',
            'kyc_verified_at'           => now(),
            'is_active'                 => true,
            'business_name'             => 'Maison Dubois Antiquités',
            'bio'                       => 'Maison d\'antiquités parisienne fondée en 1978. Spécialisée en bijoux Art Déco, montres de collection et argenterie ancienne.',
            'phone'                     => '+33 1 42 68 90 12',
            'address'                   => '15 Rue du Faubourg Saint-Honoré',
            'city'                      => 'París',
            'state'                     => 'Île-de-France',
            'country'                   => 'Francia',
            'postal_code'               => '75008',
            'stripe_onboarding_complete' => false,
            'is_featured_seller'        => false,
        ]);

        // ── BIDDERS ───────────────────────────────────────────────────────────
        User::create([
            'role'                      => 'bidder',
            'name'                      => 'Carlos Ruiz',
            'email'                     => 'bidder1@rialbids.com',
            'password'                  => Hash::make('Bidder1234!'),
            'email_verified_at'         => now(),
            'kyc_status'                => 'approved',
            'is_active'                 => true,
            'city'                      => 'Buenos Aires',
            'country'                   => 'Argentina',
        ]);

        User::create([
            'role'                      => 'bidder',
            'name'                      => 'Anna Müller',
            'email'                     => 'bidder2@rialbids.com',
            'password'                  => Hash::make('Bidder1234!'),
            'email_verified_at'         => now(),
            'kyc_status'                => 'pending',
            'is_active'                 => true,
            'city'                      => 'Berlín',
            'country'                   => 'Alemania',
        ]);

        User::create([
            'role'                      => 'bidder',
            'name'                      => 'James Wilson',
            'email'                     => 'bidder3@rialbids.com',
            'password'                  => Hash::make('Bidder1234!'),
            'email_verified_at'         => now(),
            'kyc_status'                => 'approved',
            'is_active'                 => true,
            'city'                      => 'Londres',
            'country'                   => 'Reino Unido',
        ]);

        $this->command->info('✅ Usuarios creados: ' . User::count() . ' en total');
        $this->command->info('');
        $this->command->info('   CREDENCIALES DE PRUEBA:');
        $this->command->info('   Admin:   admin@rialbids.com     / Admin1234!');
        $this->command->info('   Seller:  seller1@rialbids.com   / Seller1234!');
        $this->command->info('   Bidder:  bidder1@rialbids.com   / Bidder1234!');
    }
}
