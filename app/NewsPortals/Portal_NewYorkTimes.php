<?php

namespace App\NewsPortals;

use App\Interfaces\NewsAndArticleInterface;
use App\Models\NewsAndArticle;
use App\Models\NewsAuthor;
use App\Models\NewsSource;
use Illuminate\Support\Facades\Http;

class Portal_NewYorkTimes implements NewsAndArticleInterface
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
        //return "need to implement Portal_NewYorkTimes";

        $endpoint = "https://api.nytimes.com/svc/search/v2/articlesearch.json?q=election&api-key=2PLEAtRSz9QqchMgVgqtYehrU0cyGtZu";
        $response = Http::get($endpoint);
        $json = json_decode($response, true);

        //return $json['response']['docs'];
        $results = $json['response']['docs'];

        $sourceArr = NewsSource::pluck('source_name')->toArray();
        $authorArr = NewsAuthor::pluck('author_name')->toArray();

        foreach ($results as $item) {
            $newsAndArticle = new NewsAndArticle();
            $newsAndArticle->img                    = 'https://www.nytimes.com/'.$item['multimedia'][0]['url'];
            $newsAndArticle->title                  = $item['headline']['main'];
            $newsAndArticle->short_description      = $item['snippet'];
            $newsAndArticle->description            = $item['lead_paragraph'];
            $newsAndArticle->category               = $item['news_desk'];
            $newsAndArticle->author                 = $item['byline']['person'][0]['firstname'];
            $newsAndArticle->source                 = $item['source'];
            $newsAndArticle->publish_date           = $item['pub_date'];

            $sourceArr[] = $item['source'];
            $authorArr[] = $item['byline']['person'][0]['firstname'];

            $newsAndArticle->save();
        }

        //return $newsAndArticle;

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
