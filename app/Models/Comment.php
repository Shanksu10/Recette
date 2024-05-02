<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $table = "comments";

    protected $primaryKey = 'id';

    protected $fillable = [
        'comment',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_recipe_comment')->withPivot('recipe_id');
    }

    public function recipes()
    {
        return $this->belongsToMany(Recipe::class, 'user_recipe_comment')->withPivot('user_id');
    }
}
