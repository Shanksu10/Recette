<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRecipeComment extends Model
{
    use HasFactory;
    protected $table = "user_recipe_comment";

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'recipe_id',
        'comment_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
