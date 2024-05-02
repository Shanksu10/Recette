<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;
    protected $table = "favorites";

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'recipe_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
