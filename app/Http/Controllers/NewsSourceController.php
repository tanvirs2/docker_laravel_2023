<?php

namespace App\Http\Controllers;

use App\Models\NewsSource;
use App\Http\Requests\StoreNewsSourceRequest;
use App\Http\Requests\UpdateNewsSourceRequest;

class NewsSourceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $all = NewsSource::pluck('source_name');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNewsSourceRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(NewsSource $newsSource)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NewsSource $newsSource)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNewsSourceRequest $request, NewsSource $newsSource)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NewsSource $newsSource)
    {
        //
    }
}
