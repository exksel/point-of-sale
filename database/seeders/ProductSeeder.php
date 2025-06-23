<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'name' => 'Es Teh Original',
                'description' => 'Teh murni yang diseduh sempurna, menghadirkan kesegaran alami di setiap tegukan.',
                'stock' => 100,
                'price' => 3000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Es Teh Apel',
                'description' => 'Perpaduan harmonis teh lembut dan apel segar yang manis, siap menyegarkan harimu.',
                'stock' => 100,
                'price' => 5000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Es Teh Blackcurrant',
                'description' => 'Kombinasi unik teh dengan rasa asam-manis blackcurrant yang kaya dan menyegarkan.',
                'stock' => 100,
                'price' => 5000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Es Teh Mangga',
                'description' => 'Kesegaran teh yang dipadukan dengan manis tropis mangga juicy, memberikan sensasi liburan di setiap tegukan.',
                'stock' => 100,
                'price' => 5000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Es Teh Jeruk',
                'description' => 'Teh segar dengan cita rasa jeruk yang manis dan sedikit asam, menyegarkan serta membangkitkan semangat.',
                'stock' => 100,
                'price' => 5000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Es Teh Leci',
                'description' => 'Teh yang lembut berpadu dengan manis segarnya leci, menciptakan sensasi minum yang mewah.',
                'stock' => 100,
                'price' => 5000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Es Teh Lemon Honey',
                'description' => 'Manis alami madu dan kesegaran lemon yang memberikan energi dan kesegaran instan.',
                'stock' => 100,
                'price' => 5000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Es Teh Coklat',
                'description' => 'Minuman teh coklat yang creamy dan manis dengan rasa pekat yang memanjakan lidah.',
                'stock' => 100,
                'price' => 5000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Es Milk Tea',
                'description' => 'Kombinasi sempurna teh kaya rasa dan susu creamy yang lembut, menciptakan kelembutan dalam setiap tegukan.',
                'stock' => 100,
                'price' => 5000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Es Teh Gorio Susu',
                'description' => 'Kombinasi unik teh, susu creamy, dan manisnya biskuit gorio yang bikin nagih.',
                'stock' => 100,
                'price' => 5000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Es Teh Susu',
                'description' => 'Kesegaran teh dengan susu murni yang creamy dan lembut, memberikan kenikmatan klasik di setiap tegukan.',
                'stock' => 100,
                'price' => 5000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Es Thai Tea',
                'description' => 'Teh khas Thailand dengan aroma rempah dan susu yang creamy, menciptakan rasa autentik yang menggoda.',
                'stock' => 100,
                'price' => 6000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
