<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 20) as $index)  {
            DB::table('products')->insert([
                'name' => $faker->city,
                'price' => $faker->numberBetween($min = 500, $max = 8000),
                'qty' => $faker->numberBetween($min = 100, $max = 500),
                'image' => 'product//'.$faker->image('storage/app/public/product',640,480, null, false),
                'description'=> $faker->paragraph($nb =8)
            ]);
        }
    }
}
