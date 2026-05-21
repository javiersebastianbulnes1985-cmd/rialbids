<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
class LotesDemoSeeder extends Seeder
{
    public function run(): void
    {
        $adminId = DB::table('users')->where('email','admin@rialbids.com')->value('id');
        $cats = DB::table('categories')->pluck('id','slug');
        $now = Carbon::now();
        $lotes = [
            ['title'=>'Collar de perlas naturales cultivadas','slug'=>'collar-perlas-naturales','cat'=>'joyas','img'=>'https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?w=800','price'=>180,'reserve'=>250,'days'=>7,'cond'=>'Muy buen estado','pais'=>'Francia','desc'=>'Collar de perlas naturales cultivadas con cierre de oro blanco 18k. Certificado incluido.','featured'=>1],
            ['title'=>'Anillo oro 18k con diamante central','slug'=>'anillo-oro-18k-diamante','cat'=>'joyas','img'=>'https://images.unsplash.com/photo-1605100804763-247f67b3557e?w=800','price'=>420,'reserve'=>600,'days'=>5,'cond'=>'Excelente estado','pais'=>'Espana','desc'=>'Anillo solitario oro amarillo 18k con diamante de 0.35ct. Claridad VS1 color G.','featured'=>0],
            ['title'=>'Pulsera Art Deco platino y zafiros 1930','slug'=>'pulsera-art-deco-platino','cat'=>'joyas','img'=>'https://images.unsplash.com/photo-1611591437281-460bfbe1220a?w=800','price'=>890,'reserve'=>1200,'days'=>10,'cond'=>'Buen estado','pais'=>'Francia','desc'=>'Pulsera Art Deco en platino con zafiros azules y diamantes talla baguette.','featured'=>0],
            ['title'=>'Reloj bolsillo Longines plata 1920','slug'=>'reloj-longines-plata-1920','cat'=>'relojes','img'=>'https://images.unsplash.com/photo-1509048191080-d2984bad6ae5?w=800','price'=>320,'reserve'=>450,'days'=>6,'cond'=>'Buen estado','pais'=>'Suiza','desc'=>'Reloj de bolsillo Longines en plata 925 con cadena. Mecanismo original revisado.','featured'=>0],
            ['title'=>'Omega Seamaster automatico acero anos 70','slug'=>'omega-seamaster-automatico','cat'=>'relojes','img'=>'https://images.unsplash.com/photo-1523170335258-f5ed11844a49?w=800','price'=>650,'reserve'=>900,'days'=>8,'cond'=>'Muy buen estado','pais'=>'Suiza','desc'=>'Omega Seamaster ref 166.032 anos 70. Esfera azul original. Revisado por relojero.','featured'=>0],
            ['title'=>'Oleo paisaje mediterraneo firmado 1960','slug'=>'oleo-paisaje-mediterraneo','cat'=>'arte','img'=>'https://images.unsplash.com/photo-1579783902614-a3fb3927b6a5?w=800','price'=>280,'reserve'=>400,'days'=>9,'cond'=>'Buen estado','pais'=>'Espana','desc'=>'Pintura al oleo firmada por J. Martinez. Paisaje con barcos. 60x80cm. Marco dorado.','featured'=>0],
            ['title'=>'Acuarela retrato femenino siglo XIX','slug'=>'acuarela-retrato-femenino','cat'=>'arte','img'=>'https://images.unsplash.com/photo-1578301978693-85fa9c0320b9?w=800','price'=>150,'reserve'=>220,'days'=>7,'cond'=>'Estado aceptable','pais'=>'Espana','desc'=>'Acuarela original sobre papel verjurado. Retrato de dama con mantilla. Escuela espanola.','featured'=>0],
            ['title'=>'Comoda Luis XV nogal macizo siglo XVIII','slug'=>'comoda-luis-xv-nogal','cat'=>'muebles','img'=>'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=800','price'=>750,'reserve'=>1100,'days'=>12,'cond'=>'Restaurado','pais'=>'Francia','desc'=>'Comoda Luis XV en nogal macizo con marqueteria floral y herrajes en bronce dorado.','featured'=>0],
            ['title'=>'Porcelana Meissen pareja figuras 1880','slug'=>'porcelana-meissen-figuras','cat'=>'muebles','img'=>'https://images.unsplash.com/photo-1612198188060-c7c2a3b66eae?w=800','price'=>380,'reserve'=>550,'days'=>8,'cond'=>'Buen estado','pais'=>'Alemania','desc'=>'Pareja figuras Meissen con marcas originales. Pastores siglo XVIII. Altura 22cm.','featured'=>0],
            ['title'=>'Coleccion 48 monedas antiguas europeas','slug'=>'coleccion-monedas-europeas','cat'=>'coleccionismo','img'=>'https://images.unsplash.com/photo-1569144157591-c60f3f82f137?w=800','price'=>220,'reserve'=>320,'days'=>6,'cond'=>'Varios estados','pais'=>'Europa','desc'=>'48 monedas de plata y cobre europeas. Reales espanoles, taleros alemanes y francos.','featured'=>0],
            ['title'=>'Camara Leica M3 Summicron 50mm 1956','slug'=>'leica-m3-summicron-1956','cat'=>'coleccionismo','img'=>'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=800','price'=>480,'reserve'=>700,'days'=>10,'cond'=>'Muy buen estado','pais'=>'Alemania','desc'=>'Leica M3 serie 876xxx con Summicron 50mm f/2. Funcionando perfectamente.','featured'=>0],
            ['title'=>'Lote 12 figuras Lladro con cajas originales','slug'=>'lladro-12-figuras-cajas','cat'=>'coleccionismo','img'=>'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=800','price'=>340,'reserve'=>500,'days'=>7,'cond'=>'Excelente estado','pais'=>'Espana','desc'=>'12 figuras Lladro en porcelana con cajas originales. Marcas de base. Perfecto estado.','featured'=>0],
        ];
        foreach($lotes as $lote){
            $catId = $cats[$lote['cat']] ?? $cats->first();
            $ends = $now->copy()->addDays($lote['days']);
            DB::table('auctions')->insert([
                'user_id'=>$adminId,'category_id'=>$catId,
                'title'=>$lote['title'],'slug'=>$lote['slug'],
                'description'=>$lote['desc'],'lot_category'=>$lote['cat'],
                'base_price'=>$lote['price'],'starting_price'=>$lote['price'],
                'reserve_price'=>$lote['reserve'],'current_price'=>$lote['price'],
                'min_bid_increment'=>10,'min_increment'=>10,'commission_rate'=>9,
                'condition'=>$lote['cond'],'origin_country'=>$lote['pais'],
                'image_path'=>$lote['img'],'status'=>'active',
                'is_featured'=>$lote['featured'],'views_count'=>rand(10,80),
                'watchers_count'=>rand(1,15),'total_bids'=>0,'anti_snipe_minutes'=>5,
                'starts_at'=>$now,'ends_at'=>$ends,'end_time'=>$ends,
                'created_at'=>$now,'updated_at'=>$now,
            ]);
        }
        $this->command->info('12 lotes demo cargados.');
    }
}
