<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTurnRequest;
use App\Http\Requests\UpdateTurnRequest;
use App\Models\Movie;
use App\Models\Turn;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class TurnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $turns = Turn::orderBy('created_at', 'DESC')->paginate(10);
        return Inertia::render('Turns', ['turnList' => $turns]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('EditTurn');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTurnRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreTurnRequest $request)
    {
        Turn::create($request->only(['time', 'status']));
        return Redirect::route('turns.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Turn  $turn
     * @return \Illuminate\Http\Response
     */
    public function show(Turn $turn)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Turn  $turn
     * @return \Inertia\Response
     */
    public function edit(Turn $turn)
    {
        return Inertia::render('EditTurn', ['turn' => $turn]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTurnRequest  $request
     * @param  \App\Models\Turn  $turn
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateTurnRequest $request, Turn $turn)
    {
        $turn->update($request->only('time', 'status'));
        return Redirect::route('turns.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Turn  $turn
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Turn $turn)
    {
        $turn->delete();
        return Redirect::route('turns.index');
    }
}
