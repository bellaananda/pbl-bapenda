<?php

namespace App\Http\Controllers;

use App\Models\SuggestionDisposition;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSuggestionDispositionRequest;
use App\Http\Requests\UpdateSuggestionDispositionRequest;

class SuggestionDispositionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSuggestionDispositionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSuggestionDispositionRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SuggestionDisposition  $suggestionDisposition
     * @return \Illuminate\Http\Response
     */
    public function show(SuggestionDisposition $suggestionDisposition)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SuggestionDisposition  $suggestionDisposition
     * @return \Illuminate\Http\Response
     */
    public function edit(SuggestionDisposition $suggestionDisposition)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSuggestionDispositionRequest  $request
     * @param  \App\Models\SuggestionDisposition  $suggestionDisposition
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSuggestionDispositionRequest $request, SuggestionDisposition $suggestionDisposition)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SuggestionDisposition  $suggestionDisposition
     * @return \Illuminate\Http\Response
     */
    public function destroy(SuggestionDisposition $suggestionDisposition)
    {
        //
    }
}
