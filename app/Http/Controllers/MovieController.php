<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Movie;
use App\Models\MovieTag;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $movies = Movie::leftJoin('genres', 'genres.id', 'movies.genres')
                ->where('user_id', auth()->user()->id)
                ->select('movies.id', 'movies.title', 'movies.cover_image', 'movies.author','movies.rating', 'movies.pdf_link', 'movies.summary', 'genres.name as genre')
                ->paginate(config('constant.page_size'));
 
        return response()->json([
            'success' => true,
            'data' => $movies,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'summary' => 'required',
            'cover_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'genres' => 'required',
            'tag_id' => 'required|array',
            'author' => 'required',
            'rating' => 'required|numeric',
            'pdf_link' => 'required'
        ]);

        $success = true;
        DB::beginTransaction();
        try {
            $movie = new Movie();
            $movie->title = $request->title;
            $movie->summary = $request->summary;
            $movie->genres = $request->genres;
            $movie->author = $request->author;
            $movie->rating = $request->rating;
            $movie->pdf_link = $request->pdf_link;
            $cover_image = time().'.'.$request->cover_image->extension();  
            $request->cover_image->move(public_path('images'), $cover_image);
            $movie->cover_image = $cover_image;
            $movie->user_id = auth()->user()->id;

            if(!auth()->user()->movies()->save($movie)){
                $success = false;
                DB::rollback();
            }

            if($success){
                $tags = $request->tag_id;
                foreach ($tags as $key => $tag) {
                    $tag = MovieTag::create([
                        'movie_id' => $movie['id'],
                        'tag_id' => $tag,
                    ]);

                    if(!$tag){
                        $success = false;
                        DB::rollback();
                    }
                }
            }

            if(!$success){
                $success = false;
                DB::rollback();
            }

            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            $success = false;
            dd($e);
        }

        if($success){
            return response()->json([
                'success' => true,
                'data' => $movie->toArray()
            ]);
        }else
            return response()->json([
                'success' => false,
                'message' => 'Movie is not added'
            ], 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $movie = auth()->user()->movies()->find($id);
        if (!$movie) {
            return response()->json([
                'success' => false,
                'message' => 'Movie not found'
            ], 400);
        }

        $tags = [];
        
        $tag_data = MovieTag::where('movie_id', $movie->id)->get();
        if(count($tag_data) <> 0){
            foreach ($tag_data as $key => $tag) {
                array_push($tags, config('constant.tags.'.$tag->tag_id));
            }
        }

        $movie_data['id'] = $movie->id;
        $movie_data['title'] = $movie->title;
        $movie_data['genre'] = $movie->genre->name;
        $movie_data['cover_image'] = $movie->cover_image;
        $movie_data['author'] = $movie->author;
        $movie_data['rating'] = $movie->rating;
        $movie_data['pdf_link'] = $movie->pdf_link;
        $movie_data['summary'] = $movie->summary;
        $movie_data['tag'] = $tags;
        
        if (!$movie_data) {
            return response()->json([
                'success' => false,
                'message' => 'Movie not found '
            ], 400);
        }
 
        return response()->json([
            'success' => true,
            'data' => $movie_data
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $movie = auth()->user()->movies()->find($id);
 
        if (!$movie) {
            return response()->json([
                'success' => false,
                'message' => 'Movie not found'
            ], 400);
        }
        $data = $request->all();
        
        if($request->has('cover_image')){

            $cover_image = time().'.'.$request->cover_image->extension();  
            $request->cover_image->move(public_path('images'), $cover_image);
            $data['cover_image'] = $cover_image;

        }

        $success = true;
        DB::beginTransaction();
        try {
            $updated = $movie->update($data);
            if(!$updated){
                $success = false;
                DB::rollback();
            }else {
                if ($request->has('tag_id') && count($request->tag_id) <> 0) {
                    if(!MovieTag::where('movie_id', $id)->delete()){
                        DB::rollback();
                        $success = false;
                    }

                    $tags = $request->tag_id;
                    foreach ($tags as $key => $tag) {
                        $tag = MovieTag::create([
                            'movie_id' => $movie['id'],
                            'tag_id' => $tag,
                        ]);

                        if(!$tag){
                            $success = false;
                            DB::rollback();
                        }
                    }
                }
            }

            DB::commit();
            
        } catch (\Exception $e) {
            DB::rollback();
            $success = false;
            dd($e);
        }

        if ($success){
            return response()->json([
                'success' => true,
            ]);
        }else
            return response()->json([
                'success' => false,
                'message' => 'Movie can not be updated'
            ], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $movie = auth()->user()->movies()->find($id);
 
        if (!$movie) {
            return response()->json([
                'success' => false,
                'message' => 'Movie not found'
            ], 400);
        }
 
        if ($movie->delete()) {

            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Movie can not be deleted'
            ], 500);
        }
    }
}
