<?php

namespace App\Http\Controllers;

use App\Models\NewsAndArticle;
use App\Http\Requests\StoreNewsAndArticleRequest;
use App\Http\Requests\UpdateNewsAndArticleRequest;
use Illuminate\Support\Facades\Http;

class NewsAndArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

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
    public function store(StoreNewsAndArticleRequest $request)
    {
        $endpoint = "https://newsapi.org/v2/everything?q=Apple&from=2023-09-11&sortBy=popularity&apiKey=572294b3723746ebbbe9ba2ce111f8bb";
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
    public function show(NewsAndArticle $newsAndArticle)
    {
        //
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
