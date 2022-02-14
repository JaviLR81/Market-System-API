<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //


        $vendedores = Seller::has('products')->get();

        return response()->json(['data' => $vendedores ]);

        // $vendedores = Seller::has('products')->get();
        // return $this->showAll($vendedores);


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
        $vendedor = Seller::has('products')->findOrFail($id);
        return response()->json(['data' => $vendedor ]);

        // return $this->showOne($seller);
    }


}
