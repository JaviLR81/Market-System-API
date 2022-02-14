<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Buyer;
use Illuminate\Http\Request;

class BuyerController extends Controller
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

        return response()->json(['data' => $compradores ]);
        // return $this->showAll($compradores);
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $comprador = Buyer::has('transactions')->findOrFail($id);

        return response()->json(['data' => $comprador ]);

        // return $this->showOne($buyer);
    }


}
