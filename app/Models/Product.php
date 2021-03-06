<?php

namespace App\Models;

use App\Transformers\ProductTransformer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory,SoftDeletes;

    const PRODUCTO_DISPONIBLE = 'disponible';
    const PRODUCTO_NO_DISPONIBLE = 'no disponible';

    public $transformer = ProductTransformer::class;

    // Se especifica que esta propiedad sea tratada como una fecha
    protected $dates = ['deleted_at'];

    // El producto pertenece al vendededor por ello tiene la clave foranea
    protected $fillable = [
        'name',
        'description',
        'quantity',
        'status',
        'image',
        'seller_id'
    ];

    // Ocultando el atributo pivot
    protected $hidden = [
        'pivot'
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
