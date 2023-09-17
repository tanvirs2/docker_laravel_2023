<?php

namespace App\Console\Commands;

use App\DI_Processor\NewsAndArticleProcessor;
use App\NewsPortals\Portal_NewsApiOrg;
use App\NewsPortals\Portal_NewYorkTimes;
use App\NewsPortals\Portal_TheGuardian;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class AppInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fresh-install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fresh migrate, DB seed, Fetch Articles';

    public function newsAndArticleSaveToDB()
    {

        $this->info('Install start...');
        $this->line('');
        $this->line('"The Guardian" fetching start...');
        (new NewsAndArticleProcessor(new Portal_TheGuardian))->saveToDB(); // fetch news and articles from: "The Guardian"
        $this->info('Done! "The Guardian" Save successful!');


        $this->line('');
        $this->line('"New YorkTimes" fetching start...');
        (new NewsAndArticleProcessor(new Portal_NewYorkTimes))->saveToDB(); // fetch news and articles from: "New YorkTimes"
        $this->info('Done! "New YorkTimes" Save successful!');


        $this->line('"NewsApi.Org" fetching start...');
        (new NewsAndArticleProcessor(new Portal_NewsApiOrg))->saveToDB(); // fetch news and articles from: "NewsApi.Org"
        $this->info('Done! "NewsApi.Org" Save successful!');


    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Artisan::call('migrate:fresh');
        Artisan::call('db:seed');
        $this->newsAndArticleSaveToDB();
        $this->info('The command was successful!');
    }
}
