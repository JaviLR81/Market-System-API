<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\ApiController;
use App\Models\Buyer;

class BuyerProductController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Buyer $buyer)
    {
        // Llamando directamente a la función con el query builder
        // Aquí podemos agregar un where un find u otra restricción
        // Ya no a la relación ya no obtenemos una colección
        $products = $buyer->transactions()->with('product')
            ->get()
            // Trayendo solo una parte de la colección
            ->pluck('product');

        return $this->showAll($products);
    }

}
