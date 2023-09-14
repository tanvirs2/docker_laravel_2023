<?php

namespace App\NewsPortals;

use App\Interfaces\NewsAndArticleInterface;
use App\Models\NewsAndArticle;
use App\Models\NewsAuthor;
use App\Models\NewsSource;
use Illuminate\Support\Facades\Http;

class Portal_NewsApiOrg implements NewsAndArticleInterface
{
    private $articles;
    private $endpoint = "https://newsapi.org/v2/everything?q=Apple&from=2023-09-11&sortBy=popularity&apiKey=572294b3723746ebbbe9ba2ce111f8bb";

    /**
     * @param mixed $articles
     */
    public function setArticles($articles): void
    {
        $this->articles = $articles;
    }

    /**
     * @return mixed
     */
    public function getArticles()
    {
        return $this->articles;
    }

    function removeSpecialChar($str) {

        // Using str_replace() function
        // to replace the word
        $res = str_replace( array( '\'', '"',
            ',' , ';', '<', '>' ), ' ', $str);

        // Returning the result
        return $res;
    }

    public function fetchNewsAndArticle()
    {
        // TODO: Implement fetchNewsAndArticle() method.

        //dd(date('d')-1);
        //dd(date('Y-m-') . date('d')-1);

        $previousDay = date('Y-m-') . date('d') - 1;

        $endpoint = "https://newsapi.org/v2/everything?q=Apple&from=$previousDay&sortBy=popularity&apiKey=572294b3723746ebbbe9ba2ce111f8bb";
        $endpoint = "https://newsapi.org/v2/everything?q=Apple&sortBy=popularity&apiKey=572294b3723746ebbbe9ba2ce111f8bb";
        //dd($endpoint);
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

    public function saveToDB()
    {
        // TODO: Implement saveToDB() method.
    }
}
