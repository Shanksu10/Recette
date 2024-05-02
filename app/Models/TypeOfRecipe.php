<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeOfRecipe extends Model
{
    use HasFactory;

    protected $table='types_of_recipes';
    protected $primaryKey='id';

    protected $fillable = [
        'recipe_id',
        'type_recipe_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        
    ];
}
