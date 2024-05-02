<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryOfRecipe extends Model
{
    use HasFactory;

    protected $table='categories_of_recipes';
    protected $primaryKey='id';

    protected $fillable = [
        'recipe_id',
        'category_recipe_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        
    ];
}
