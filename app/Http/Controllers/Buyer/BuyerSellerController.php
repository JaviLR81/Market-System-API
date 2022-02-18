<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\ApiController;
use App\Models\Buyer;

class BuyerSellerController extends ApiController
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
    public function index(Buyer $buyer)
    {
        //
        // $this->allowedAdminAction();
        $sellers = $buyer->transactions()->with('product.seller')
            ->get()
            ->pluck('product.seller')
            ->unique('id')
            ->values();

        return $this->showAll($sellers);
    }
}
