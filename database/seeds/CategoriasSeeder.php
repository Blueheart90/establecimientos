<?php


use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('categorias')->insert([
        //     'nombre' => 'Restaurante',
        //     'slug' => Str::slug('Restaurante'),
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);

        $categorias = [
            [
                'nombre' => 'Restaurante',
                'slug' => Str::slug('Restaurante'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nombre' => 'Café',
                'slug' => Str::slug('Café'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nombre' => 'Hotel',
                'slug' => Str::slug('Hotel'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nombre' => 'Bar',
                'slug' => Str::slug('Bar'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nombre' => 'Hospital',
                'slug' => Str::slug('Hospital'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nombre' => 'Gimnasio',
                'slug' => Str::slug('Gimnasio'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nombre' => 'Doctor',
                'slug' => Str::slug('Doctor'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];
        DB::table('categorias')->insert($categorias);
    }
}
