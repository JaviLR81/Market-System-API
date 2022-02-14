<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;

class BuyerScope implements Scope
{
    // Modificar la consulta tipica del modelo agregando
    // La restricción de las transacciones
	public function apply(Builder $builder, Model $model)
	{
		$builder->has('transactions');
	}
}
