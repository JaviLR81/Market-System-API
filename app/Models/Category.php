<?php

namespace App\Models;

use App\Transformers\CategoryTransformer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    public $transformer = CategoryTransformer::class;

    // Se especifica que esta propiedad sea tratada como una fecha
    protected $dates = ['deleted_at'];

    // Mass asigment
    protected $fillable = [
        'name',
        'description',
    ];

    // Ocultando el atributo pivot
    protected $hidden = [
        'pivot'
    ];


    // Muchos a muchos
    public function products(){
        return $this->belongsToMany(Product::class);
    }

}
