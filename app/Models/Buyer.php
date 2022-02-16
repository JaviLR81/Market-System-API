<?php

namespace App\Models;

use App\Scopes\BuyerScope;
use App\Transformers\BuyerTransformer;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Buyer extends User
{
    use HasFactory;

    public $transformer = BuyerTransformer::class;


    //  Construir e inicializar el modelo
    protected static function boot()
	{
        // Llamar al boot del padre del modelo base
        // Para mantener el comportamiento original de Laravel
		parent::boot();

        // Añadiendo la funcionalidad del Scope
		static::addGlobalScope(new BuyerScope);
	}

    // Un comprador esta en capacidad de comprar muchas veces
    public function transactions(){
        return $this->hasMany(Transaction::class);
    }

}
