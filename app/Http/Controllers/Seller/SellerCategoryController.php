<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Models\Seller;

class SellerCategoryController extends ApiController
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
    public function index(Seller $seller)
    {
        $categories = $seller->products()
            ->with('categories')
            ->get()
            ->pluck('categories')
            ->collapse()
            ->unique('id')
            ->values();

        return $this->showAll($categories);
    }

}
