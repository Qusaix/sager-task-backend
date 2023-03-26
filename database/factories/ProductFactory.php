<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'description' => fake()->text(),
            'quantity' => fake()->numberBetween(1,1000),
            'price' => fake()->numberBetween(1,1000),
            'user_id'=>1
        ];
    }


    public function configure()
    {
        return $this->afterMaking(function (Product $item) {
            // add some additional behavior after making the item model
           // $item->categories()->sync([1]);
        })->afterCreating(function (Product $item) {
            // add some additional behavior after creating the item model
            $item->categories()->sync([1]);
        });
    }
}
