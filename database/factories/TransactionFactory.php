<?php

namespace Database\Factories;

use App\Models\Seller;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // Un usuario que podamos catalogar como vendedor oficial
        $vendedor = Seller::has('products')->get()->random();
        // Un comprador no puede comprar sus propios productos
        // No necesariamente que ya tenga compras
        $comprador = User::all()->except($vendedor->id)->random();

        return [
            //
            'quantity' => $this->faker->numberBetween(1, 3),
            'buyer_id' => $comprador->id,
            'product_id' => $vendedor->products->random()->id
        ];
    }
}
