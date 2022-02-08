<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Buyer extends User
{
    use HasFactory;

    // Un comprador esta en capacidad de comprar muchas veces
    public function transactions(){
        return $this->hasMany(Transaction::class);
    }

}
