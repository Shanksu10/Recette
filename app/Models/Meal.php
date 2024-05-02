<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Meal extends Model
{
    use HasFactory;

    protected $primaryKey='id';

    protected $fillable = [
        'name_meal',
        'user_id',
        'picture_meal'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function users(){

        return $this->belongsTo(User::class);
    }

    public function recipes()
    {
        return $this->belongsToMany(Recipe::class, 'meal_recipe', 'meal_id', 'recipe_id');
    }

    public function categories(){
        
        return $this->belongsToMany(CategoryMeal::class, 'categories_of_meals', 'meal_id', 'category_meal_id');
    }
}
