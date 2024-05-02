<?php


namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\TypeRecipe;

class TypeRecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TypeRecipe::create(['name_type_recipe' => 'dessert']);
        TypeRecipe::create(['name_type_recipe' => 'plat principal']);
        TypeRecipe::create(['name_type_recipe' => 'entrée']);
    }
}
