<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'summary', 'cover_image', 'genres', 'author', 'rating', 'pdf_link'];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected static function boot(){
		parent::boot();
		static::deleted (function($movie){
			$movie->comments()->delete();
            $movie->tags()->delete();
		});
	}

	public function comments(){
		return $this->hasMany(Comment::class);
	}

    public function tags(){
		return $this->hasMany(MovieTag::class);
	}

	public function genre(){
		return $this->hasOne(Genre::class, 'id', 'genres');
	}
}
