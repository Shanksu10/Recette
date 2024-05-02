<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryRecipe extends Model
{
    use HasFactory;
    protected $primaryKey='id';

    protected $fillable = [
        'name_category_recipe'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        
    ];

    public function recipes()
    {
        return $this->belongsToMany(Recipe::class, 'categories_of_recipes', 'category_recipe_id', 'recipe_id');
    }
}
