<?php

namespace App\Http\Controllers;

use App\Interfaces\NewsAndArticleInterface;
use App\Models\NewsAndArticle;
use App\Http\Requests\StoreNewsAndArticleRequest;
use App\Http\Requests\UpdateNewsAndArticleRequest;
use App\Models\NewsAuthor;
use App\Models\NewsSource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class NewsAndArticleController extends Controller
{
    public function ifNullAssign($field)
    {
        if ($field == 'null') {
            $field = null;
        }
        return $field;
    }
    /**
     * Display a listing of the resource.
     * use Illuminate\Http\Request;
     */
    public function index(Request $request)
    {
        $personalizeProfile = Auth::user()->personalizeProfile;

        $query = NewsAndArticle::query();

        $request['title'] = $this->ifNullAssign($request['title']);
        $request['from'] = $this->ifNullAssign($request['from']);
        $request['to'] = $this->ifNullAssign($request['to']);
        $request['source'] = $this->ifNullAssign($request['source']);
        $request['author'] = $this->ifNullAssign($request['author']);
        $request['btnClicked'] = $this->ifNullAssign($request['btnClicked']);

        //return $request['btnClicked'];

        if (!$request['btnClicked']) {
            $query = $query->limit(50);
        }

        if ($request['title']) {
            $query = $query->where('title', 'LIKE', "%$request->title%");
        }

        if ($request['source']) {
            $query = $query->where('source', $request['source']);
        }

        if ($request['author']) {
            $query = $query->where('author', $request['author']);
        }

        if ($request->from) {
            if ($request->to) {
                $query = $query->whereBetween('publish_date',  [$request->from, $request->to]);
            }
        }

        //return $query->latest()->get();
        //dd($query->latest()->get());

        if ($personalizeProfile && $personalizeProfile->status == 'on') {
            if ($request->filterType == 'source') {
                $sources = json_decode($personalizeProfile->sources);
                $query = $query->whereIn('source', $sources);
            }else{
                $authors = json_decode($personalizeProfile->authors);
                $query = $query->whereIn('author', $authors);
            }
        }

        return $query->latest()->get();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //..
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNewsAndArticleRequest $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $newsAndArticle = NewsAndArticle::findOrFail($id);
        return $newsAndArticle;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NewsAndArticle $newsAndArticle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNewsAndArticleRequest $request, NewsAndArticle $newsAndArticle)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NewsAndArticle $newsAndArticle)
    {
        //
    }
}
