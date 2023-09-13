<?php

namespace App\DI_Processor;

use App\Interfaces\NewsAndArticleInterface;

class NewsAndArticleProcessor
{
    private $newsAndArticleObject;

    public function __construct(NewsAndArticleInterface $newsAndArticle)
    {
        $this->newsAndArticleObject = $newsAndArticle;
    }

    public function saveToDB()
    {
        $this->newsAndArticleObject->saveToDB();
    }

}
