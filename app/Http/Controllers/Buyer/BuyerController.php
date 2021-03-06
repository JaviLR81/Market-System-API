<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Buyer;
use Illuminate\Http\Request;

class BuyerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Obteniendo unicamente los usuarios que tienen transacciones
        $compradores = Buyer::has('transactions')->get();
        return $this->showAll($compradores);
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Buyer $buyer)
    {
        // Ya no es necesaria la relación directa por que esta siendo manejada
        // Por medio de un global scope
        // $comprador = Buyer::has('transactions')->findOrFail($id);
        return $this->showOne($buyer);
    }

}
