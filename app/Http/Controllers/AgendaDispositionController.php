<?php

namespace App\Http\Controllers;

use App\Models\AgendaDisposition;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAgendaDispositionRequest;
use App\Http\Requests\UpdateAgendaDispositionRequest;

class AgendaDispositionController extends Controller
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
     * @param  \App\Http\Requests\StoreAgendaDispositionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAgendaDispositionRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AgendaDisposition  $agendaDisposition
     * @return \Illuminate\Http\Response
     */
    public function show(AgendaDisposition $agendaDisposition)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AgendaDisposition  $agendaDisposition
     * @return \Illuminate\Http\Response
     */
    public function edit(AgendaDisposition $agendaDisposition)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAgendaDispositionRequest  $request
     * @param  \App\Models\AgendaDisposition  $agendaDisposition
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAgendaDispositionRequest $request, AgendaDisposition $agendaDisposition)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AgendaDisposition  $agendaDisposition
     * @return \Illuminate\Http\Response
     */
    public function destroy(AgendaDisposition $agendaDisposition)
    {
        //
    }
}
