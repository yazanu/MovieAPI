<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\MovieTag;
use App\Models\Comment;

class HomeController extends Controller
{
    public function getMovieLists()
    {
        $data = Movie::leftJoin('genres', 'genres.id', 'movies.genres')
        ->latest('movies.id')
        ->select('movies.id', 'movies.title', 'movies.cover_image', 'movies.author','movies.rating', 'movies.pdf_link', 'movies.summary', 'genres.name as genre')
        ->paginate(config('constant.page_size'));

        return response()->json([
            'data' => $data,
        ]);
    }

    public function getMovieDetail($movie_id)
    {
        $movie = Movie::with('genre:id,name','comments')->find($movie_id);

        $tags_data = [];
        $tags = MovieTag::where('movie_id', $movie_id)->get();
        if(count($tags) <> 0){
            foreach ($tags as $key => $tag) {
                array_push($tags_data, config('constant.tags.'.$tag->tag_id));
            }
        }
        $movie['tag'] = $tags_data;
        
        $m = Movie::findOrFail($movie_id);
        $relatedMovies = Movie::where('movies.id', '<>', $movie_id)
        ->where('author', $m->author)
        ->orWhereHas('genre', function ($query) use ($m) {
            $query->where('genres.id', $m->genre->id);
        })
        ->orWhereHas('tags', function ($query) use ($m) {
            $query->whereIn('movie_tags.id', $m->tags->pluck('id'));
        })
        ->orderByDesc('rating')
        ->take(7)
        ->get();

        $movie['related_movies'] = $relatedMovies;

        return $movie;
    }

    public function commentMovie(Request $request, $movie_id)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'comment' => 'required',
        ]);
        
        $success = true;
        $data = $request->all();
        $data['movie_id'] = $movie_id;
        if(!Comment::create($data)){
            $success = false;
        }

        if($success){
            return response()->json([
                'success' => true,
                'message' => 'Your comment is successfully added.'
            ]);
        }else
            return response()->json([
                'success' => false,
                'message' => 'Your comment is not added. Please try again'
            ], 500);
    }

}
