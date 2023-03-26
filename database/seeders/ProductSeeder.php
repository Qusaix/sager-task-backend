<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       // Define the number of items you want to create
       $count = 1000;
        
       // Use the factory to create $count number of items
       Product::factory()->count($count)->create();
    }
}
