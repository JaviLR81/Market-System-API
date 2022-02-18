<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\ApiController;
use App\Models\Transaction;

class TransactionSellerController extends ApiController
{

    public function __construct()
    {
        // Llamar al constructor del padre para no perder alguna tarea del padre en su constructor
        // En especial para heredar su middleare de auth:api
        parent::__construct();
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Transaction $transaction)
    {
        //
        $seller = $transaction->product->seller;

        return $this->showOne($seller);
    }


}
