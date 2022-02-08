<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    const PRODUCTO_DISPONIBLE = 'disponible';
    const PRODUCTO_NO_DISPONIBLE = 'no disponible';

    // El producto pertenece al vendededor por ello tiene la clave foranea
    protected $fillable = [
        'name',
        'description',
        'quantity',
        'status',
        'image',
        'seller_id'
    ];

    public function estaDisponible(){
        return $this->status == Product::PRODUCTO_DISPONIBLE;
    }

    // Muchos a muchos
    public function categories(){
        return $this->belongsToMany(Category::class);
    }

    // Un producto pertenece a un vendedor
    // Un estado pertenece a un pais
    // Un programador pertenece a una empresa
    public function seller(){
        return $this->belongsTo(Seller::class);
    }

    // Un producto tiene muchas transaccciones, esta presente en muchas transacciones
    public function transactions(){
        return $this->hasMany(Transaction::class);
    }


}
