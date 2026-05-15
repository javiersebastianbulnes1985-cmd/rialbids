<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('');
        $this->command->info('🚀 Iniciando seeders de RialBids...');
        $this->command->info('');

        // ORDEN IMPORTANTE: respetar las foreign keys
        $this->call([
            CategorySeeder::class,  // 1ro: sin dependencias
            UserSeeder::class,      // 2do: sin dependencias
            // AuctionSeeder::class  // 3ro: próximo módulo
        ]);

        $this->command->info('');
        $this->command->info('✅ RialBids listo para usar.');
        $this->command->info('');
    }
}
