<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryOfMeal extends Model
{
    use HasFactory;

    protected $table='categories_of_meals';
    protected $primaryKey='id';

    protected $fillable = [
        'meal_id',
        'category_meal_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        
    ];
}
