<?php

namespace App\Http\Controllers;
use App\Interfaces\NewsAndArticleInterface;
use App\NewsPortals\Portal_NewsApiOrg;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//App::bind(NewsAndArticleInterface::class, Portal_NewsApiOrg::class);

Route::get('/', function () {

    /*$data = '{
          "action": "getArticles",
          "keyword": "Barack Obama",
          "articlesPage": 1,
          "articlesCount": 100,
          "articlesSortBy": "date",
          "articlesSortByAsc": false,
          "articlesArticleBodyLen": -1,
          "resultType": "articles",
          "dataType": [
            "news",
            "pr"
          ],
          "apiKey": "d18d09e9-d409-4452-b962-6e11d5966acd",
          "forceMaxDataTimeWindow": 31
        }';

    $url = 'http://eventregistry.org/api/v1/article/getArticles';

    //return json_decode($data);

    $result = Http::withBody($data, 'application/json')->get($url);*/

    //return json_decode($result);

    return ['Laravel' => app()->version()];
});

Route::get('fetch-news-save/{lowerModule}', function ($lowerModule){
    $newsPortals = App::make('App\NewsPortals\\'.$lowerModule);
    return $newsPortals->fetchNewsAndArticle();
});

Route::get('scrapping/save/{lowerModule}', [NewsAndArticleController::class, 'scrappingAndSave'])
    //->middleware(['auth:sanctum'])
;

Route::resource('scrapping', NewsAndArticleController::class)
    //->middleware(['auth:sanctum'])
;

Route::resource('personalize-profile', PersonalizeProfileController::class);
Route::resource('news-source', NewsSourceController::class);
Route::resource('news-author', NewsAuthorController::class);


require __DIR__.'/auth.php';
