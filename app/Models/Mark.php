<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mark extends Model
{
    use HasFactory;
    protected $table = "marks";

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'recipe_id',
        'mark'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
