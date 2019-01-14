<?php

use App\Product;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::truncate();

        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 5; $i++) {
            Product::create([
                'name' => $faker->sentence,
                'description' => $faker->paragraph,
                'price' => $faker->randomFloat(8,0.0, 100000.00),
                'user_id' => 1
            ]);
        }
    }
}
