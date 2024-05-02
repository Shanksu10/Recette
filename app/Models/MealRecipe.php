<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MealRecipe extends Model
{
    use HasFactory;
    protected $table = "meal_recipe";

    protected $primaryKey = 'id';

    protected $fillable = [
        'meal_id',
        'recipe_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
