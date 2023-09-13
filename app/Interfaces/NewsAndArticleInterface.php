<?php

namespace App\Interfaces;

interface NewsAndArticleInterface
{
    public function fetchNewsAndArticle();
    public function saveToDB();
    public function setArticles($articles);
    public function getArticles();
}
