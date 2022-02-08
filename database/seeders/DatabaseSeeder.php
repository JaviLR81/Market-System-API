<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // Debido a que son borrados desordenados
        // Vamos a desactivar la verificación de tablas foraneas
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        // Vaciando las tablas lo que hay en la base, borrar lo que hay en la tabla sin borrar la tabla
        // Para evitar que cada vez que se ejecuta el seeder se llene de información
        User::truncate();
        Category::truncate();
        Product::truncate();
        Transaction::truncate();
        DB::table('category_product')->truncate();

        User::flushEventListeners();
        Category::flushEventListeners();
        Product::flushEventListeners();
        Transaction::flushEventListeners();

        $cantidadUsuarios = 1000;
        $cantidadCategorias = 30;
        $cantidadProductos = 1000;
        $cantidadTransacciones = 1000;


        \App\Models\User::factory($cantidadUsuarios)->create();

        \App\Models\Category::factory($cantidadCategorias)->create();

        \App\Models\Product::factory($cantidadProductos)->create()->each(
            function ($producto) {
                $categorias = \App\Models\Category::all()->random(mt_rand(1, 5))->pluck('id');

                $producto->categories()->attach($categorias);
            }
        );

        \App\Models\Transaction::factory($cantidadTransacciones)->create();
    }
}
