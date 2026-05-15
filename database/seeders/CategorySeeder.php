<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            // ── JOYERÍA ──────────────────────────────────────────────────────
            [
                'name'            => 'Joyería',
                'description'     => 'Joyas finas, de colección y de diseño',
                'commission_rate' => 15.00,
                'icon'            => '💍',
                'sort_order'      => 1,
                'children'        => [
                    ['name' => 'Anillos',          'sort_order' => 1],
                    ['name' => 'Collares y Cadenas','sort_order' => 2],
                    ['name' => 'Pulseras',          'sort_order' => 3],
                    ['name' => 'Pendientes',        'sort_order' => 4],
                    ['name' => 'Broches y Prendedores', 'sort_order' => 5],
                    ['name' => 'Conjuntos de Joyería',  'sort_order' => 6],
                    ['name' => 'Joyería Vintage',   'sort_order' => 7],
                    ['name' => 'Joyería Art Déco',  'sort_order' => 8],
                ],
            ],

            // ── RELOJES ───────────────────────────────────────────────────────
            [
                'name'            => 'Relojes',
                'description'     => 'Relojes de lujo, vintage y de colección',
                'commission_rate' => 12.00,
                'icon'            => '⌚',
                'sort_order'      => 2,
                'children'        => [
                    ['name' => 'Relojes de Hombre',  'sort_order' => 1],
                    ['name' => 'Relojes de Mujer',   'sort_order' => 2],
                    ['name' => 'Relojes Vintage',    'sort_order' => 3],
                    ['name' => 'Relojes de Bolsillo', 'sort_order' => 4],
                    ['name' => 'Relojes de Lujo',    'sort_order' => 5],
                ],
            ],

            // ── ARTE ──────────────────────────────────────────────────────────
            [
                'name'            => 'Arte',
                'description'     => 'Pinturas, esculturas y obras de arte originales',
                'commission_rate' => 18.00,
                'icon'            => '🎨',
                'sort_order'      => 3,
                'children'        => [
                    ['name' => 'Pinturas al Óleo',   'sort_order' => 1],
                    ['name' => 'Acuarelas',           'sort_order' => 2],
                    ['name' => 'Grabados y Litografías', 'sort_order' => 3],
                    ['name' => 'Fotografía de Arte',  'sort_order' => 4],
                    ['name' => 'Arte Digital',        'sort_order' => 5],
                    ['name' => 'Esculturas',          'sort_order' => 6],
                    ['name' => 'Arte Moderno',        'sort_order' => 7],
                    ['name' => 'Arte Contemporáneo',  'sort_order' => 8],
                ],
            ],

            // ── GEMAS Y MINERALES ─────────────────────────────────────────────
            [
                'name'            => 'Gemas y Minerales',
                'description'     => 'Piedras preciosas, semipreciosas y minerales de colección',
                'commission_rate' => 15.00,
                'icon'            => '💎',
                'sort_order'      => 4,
                'children'        => [
                    ['name' => 'Diamantes',           'sort_order' => 1],
                    ['name' => 'Rubíes y Zafiros',    'sort_order' => 2],
                    ['name' => 'Esmeraldas',          'sort_order' => 3],
                    ['name' => 'Perlas',              'sort_order' => 4],
                    ['name' => 'Piedras Semipreciosas','sort_order' => 5],
                    ['name' => 'Minerales y Cristales','sort_order' => 6],
                ],
            ],

            // ── ANTIGÜEDADES ──────────────────────────────────────────────────
            [
                'name'            => 'Antigüedades',
                'description'     => 'Objetos históricos, antigüedades y coleccionables',
                'commission_rate' => 15.00,
                'icon'            => '🏺',
                'sort_order'      => 5,
                'children'        => [
                    ['name' => 'Platería y Orfebrería', 'sort_order' => 1],
                    ['name' => 'Porcelana y Cerámica',  'sort_order' => 2],
                    ['name' => 'Muebles Antiguos',      'sort_order' => 3],
                    ['name' => 'Monedas y Medallas',    'sort_order' => 4],
                    ['name' => 'Libros Antiguos',       'sort_order' => 5],
                    ['name' => 'Instrumentos Musicales','sort_order' => 6],
                ],
            ],

            // ── LUJO Y MODA ───────────────────────────────────────────────────
            [
                'name'            => 'Lujo y Moda',
                'description'     => 'Accesorios de lujo, bolsos y artículos de moda premium',
                'commission_rate' => 15.00,
                'icon'            => '👜',
                'sort_order'      => 6,
                'children'        => [
                    ['name' => 'Bolsos de Diseñador',  'sort_order' => 1],
                    ['name' => 'Accesorios de Lujo',   'sort_order' => 2],
                    ['name' => 'Ropa Vintage',         'sort_order' => 3],
                    ['name' => 'Zapatos de Colección', 'sort_order' => 4],
                ],
            ],
        ];

        foreach ($categories as $categoryData) {
            $children = $categoryData['children'] ?? [];
            unset($categoryData['children']);

            $parent = Category::create([
                'parent_id'       => null,
                'name'            => $categoryData['name'],
                'slug'            => Str::slug($categoryData['name']),
                'description'     => $categoryData['description'] ?? null,
                'commission_rate' => $categoryData['commission_rate'] ?? null,
                'icon'            => $categoryData['icon'] ?? null,
                'sort_order'      => $categoryData['sort_order'] ?? 0,
                'is_active'       => true,
            ]);

            foreach ($children as $child) {
                Category::create([
                    'parent_id'   => $parent->id,
                    'name'        => $child['name'],
                    'slug'        => Str::slug($child['name']) . '-' . $parent->id,
                    'sort_order'  => $child['sort_order'] ?? 0,
                    'is_active'   => true,
                ]);
            }
        }

        $this->command->info('✅ Categorías creadas: ' . Category::count() . ' en total');
    }
}
