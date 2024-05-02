<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryMeal extends Model
{
    use HasFactory;

    protected $primaryKey='id';

    protected $fillable=[
        'name_category_meal'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function meals(){

        return $this->belongsToMany(Meal::class, 'categories_of_meals', 'category_meal_id', 'meal_id');
    }
}
