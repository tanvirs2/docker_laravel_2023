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

        if ($request['title']) {
            $query = $query->where('title', 'LIKE', "%$request->title%");
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

    public function scrappingAndSave()
    {
        //return '$newsAndArticleDi';
        $endpoint = "https://newsapi.org/v2/everything?q=Apple&from=2023-09-11&sortBy=popularity&apiKey=572294b3723746ebbbe9ba2ce111f8bb";
        $response = Http::get($endpoint);
        $json =  json_decode($response, true);


        $sourceArr = NewsSource::pluck('source_name')->toArray();
        $authorArr = NewsAuthor::pluck('author_name')->toArray();

        foreach ($json['articles'] as $item) {
            $newsAndArticle = new NewsAndArticle();
            $newsAndArticle->img                    = $item['urlToImage'];
            $newsAndArticle->title                  = $item['title'];
            $newsAndArticle->short_description      = $item['description'];
            $newsAndArticle->description            = $item['content'];
            $newsAndArticle->category               = 'not found';
            $newsAndArticle->author                 = $this->removeSpecialChar($item['author']);
            $newsAndArticle->source                 = $this->removeSpecialChar($item['source']['name']);
            $newsAndArticle->publish_date           = $item['publishedAt'];

            $sourceArr[] = $this->removeSpecialChar($item['source']['name']);
            $authorArr[] = $this->removeSpecialChar($item['author']);

            //echo $item['title'] . '<br>';
            $newsAndArticle->save();
        }

        $sourceArr = array_unique($sourceArr);

        foreach ($sourceArr as $source) {
            $newsSource = new NewsSource();
            $newsSource->source_name = $source;
            $newsSource->save();
        }

        $authorArr = array_unique($authorArr);

        //return ($authorArr);

        foreach ($authorArr as $author) {
            $newsAuthor = new NewsAuthor();
            $newsAuthor->author_name = $author;
            $newsAuthor->save();
        }

        return [$sourceArr, $authorArr];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNewsAndArticleRequest $request)
    {
        $endpoint = "https://newsapi.org/v2/everything?q=Apple&from=2023-09-10&sortBy=popularity&apiKey=572294b3723746ebbbe9ba2ce111f8bb";
        $response = Http::get($endpoint);
        $json =  json_decode($response, true);

        //return $json;

        /*$client = new \GuzzleHttp\Client();
        $res = $client->get($endpoint);
        $content = $res->getBody();
        $json = json_decode($content, true);*/

        foreach ($json['articles'] as $item) {
            $newsAndArticle = new NewsAndArticle();
            $newsAndArticle->img                    = $item['urlToImage'];
            $newsAndArticle->title                  = $item['title'];
            $newsAndArticle->short_description      = $item['description'];
            $newsAndArticle->description            = $item['content'];
            $newsAndArticle->category               = 'not found';
            $newsAndArticle->author                 = $item['author'];
            $newsAndArticle->source                 = $item['source']['name'];
            $newsAndArticle->publish_date           = $item['publishedAt'];

            //echo $item['title'] . '<br>';
            //$newsAndArticle->save();
        }
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
