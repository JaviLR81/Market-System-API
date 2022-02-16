<?php

namespace App\Models;

use App\Transformers\TransactionTransformer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    public $transformer = TransactionTransformer::class;

    // Se especifica que esta propiedad sea tratada como una fecha
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'quantity',
        'buyer_id',
        'product_id'
    ];

    // Una transacción pertenece a un comprador
    public function buyer(){
        return $this->belongsTo(Buyer::class);
    }

    // Una trasacción pertenece a un producto
    public function product(){
        return $this->belongsTo(Product::class);
    }
}
