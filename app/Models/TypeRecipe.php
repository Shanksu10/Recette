<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeRecipe extends Model
{
    use HasFactory;
    protected $primaryKey='id';

    protected $fillable = [
        'name_type_recipe'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        
    ];

    public function recipes()
    {
        return $this->belongsToMany(Recipe::class, 'types_of_recipes','type_recipe_id','recipe_id');
    }

 
}
