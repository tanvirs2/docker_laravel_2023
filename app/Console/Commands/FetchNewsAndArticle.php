<?php

namespace App\Console\Commands;

use App\DI_Processor\NewsAndArticleProcessor;
use App\NewsPortals\Portal_NewsApiOrg;
use App\NewsPortals\Portal_NewYorkTimes;
use App\NewsPortals\Portal_TheGuardian;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class FetchNewsAndArticle extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-news-and-article';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'fetch-news-and-article-for-today';

    public static function newsAndArticleSaveToDB()
    {
        (new NewsAndArticleProcessor(new Portal_TheGuardian))->saveToDB();
        (new NewsAndArticleProcessor(new Portal_NewYorkTimes))->saveToDB();
        (new NewsAndArticleProcessor(new Portal_NewsApiOrg))->saveToDB();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->newsAndArticleSaveToDB();
    }
}
