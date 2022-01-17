<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use App\Models\Movie;
use App\Models\Turn;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $turns = Turn::where('status', true)->get();
        $movies = Movie::orderBy('published_at', 'DESC')->with('turns')->paginate(10);
        return Inertia::render('Movies', ['movieList' => $movies, 'turns' => $turns]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('EditMovie');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMovieRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreMovieRequest $request)
    {
        $data = $request->only('name', 'published_at');

        if ($request->has('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('public/images/movies');
            $data['thumbnail'] = url(str_replace('public/', 'storage/', $data['thumbnail']));
        }

        Movie::create($data);
        return Redirect::route('movies.index');

    }

    /**
     * Display the specified resource.
     *
     * @param Movie $movie
     * @return \Illuminate\Http\Response
     */
    public function show(Movie $movie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Movie $movie
     * @return \Inertia\Response
     */
    public function edit(Movie $movie)
    {
        return Inertia::render('EditMovie', ['movie' => $movie]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMovieRequest  $request
     * @param Movie $movie
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateMovieRequest $request, Movie $movie)
    {

        if ($request->has('turns')) {
            $movie->turns()->sync($request->turns);
            return Redirect::route('movies.index');
        }

        $data = $request->only('name', 'status', 'published_at');

        if ($request->has('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('public/movies');
            $data['thumbnail'] = url(str_replace('public/', 'storage/', $data['thumbnail']));
        }


        $movie->update($data);
        return Redirect::route('movies.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Movie $movie
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Movie $movie)
    {
        $movie->delete();
        return Redirect::route('movies.index');
    }
}
