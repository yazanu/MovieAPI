<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovieTag extends Model
{
    use HasFactory;

    protected $fillable = ['movie_id', 'tag_id'];

    protected $hidden = ['created_at', 'updated_at'];
}
