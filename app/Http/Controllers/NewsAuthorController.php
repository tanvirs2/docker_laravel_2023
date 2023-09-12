<?php

namespace App\Http\Controllers;

use App\Models\NewsAuthor;
use App\Http\Requests\StoreNewsAuthorRequest;
use App\Http\Requests\UpdateNewsAuthorRequest;

class NewsAuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $all = NewsAuthor::pluck('author_name');
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
    public function store(StoreNewsAuthorRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(NewsAuthor $newsAuthor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NewsAuthor $newsAuthor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNewsAuthorRequest $request, NewsAuthor $newsAuthor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NewsAuthor $newsAuthor)
    {
        //
    }
}
