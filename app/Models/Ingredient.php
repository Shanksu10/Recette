<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;
    protected $table = "ingredients";

    protected $primaryKey = 'id';

    protected $fillable = [
        'name_ingredient',
        'nutri_value',
        'unit'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function recipes()
    {
        return $this->belongsToMany(Recipe::class, 'ingredient_recipe', 'ingredient_id', 'recipe_id');
    }

}
