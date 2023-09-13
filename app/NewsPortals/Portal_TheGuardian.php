<?php

namespace App\NewsPortals;

use App\Interfaces\NewsAndArticleInterface;
use App\Models\NewsAndArticle;
use App\Models\NewsAuthor;
use App\Models\NewsSource;
use Illuminate\Support\Facades\Http;

class Portal_TheGuardian implements NewsAndArticleInterface
{
    private $articles;

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

    public function fetchNewsAndArticle()
    {
        // TODO: Implement fetchNewsAndArticle() method.
        //return "need to implement Portal_TheGuardian";

        $endpoint = "https://content.guardianapis.com/search?format=json&api-key=933d742f-68bf-43f4-a664-2e0c3ce36a03";

        $response = Http::get($endpoint);
        $json =  json_decode($response, true);

        //return $json;

        $sourceArr = NewsSource::pluck('source_name')->toArray();
        $authorArr = NewsAuthor::pluck('author_name')->toArray();

        $results = $json['response']['results'];

        foreach ($results as $item) {
            $newsAndArticle = new NewsAndArticle();
            //$newsAndArticle->img                    = $item['urlToImage'];
            $newsAndArticle->title                  = $item['webTitle'];
            $newsAndArticle->short_description      = $item['webTitle'];
            $newsAndArticle->description            = $item['webUrl'];
            $newsAndArticle->category               = $item['sectionName'];
            $newsAndArticle->author                 = 'TheGuardian';
            $newsAndArticle->source                 = $item['pillarName'];
            $newsAndArticle->publish_date           = $item['webPublicationDate'];

            $sourceArr[] = $item['pillarName'];
            //$authorArr[] = 'TheGuardian';

            $newsAndArticle->save();
        }
        //return ($newsAndArticle);

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
