<?php

namespace App\Http\Controllers;
use App\Interfaces\NewsAndArticleInterface;
use App\NewsPortals\Portal_NewsApiOrg;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
//use mysql_xdevapi\Exception;

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

Route::get('/install', function () {

    Artisan::call('migrate:fresh');
    Artisan::call('db:seed');

    return 'done!';

});

Route::get('/fresh-install', function () {

    $execute = Artisan::call('app:fresh-install');

    return 'fresh-install done!';

});

Route::get('/fetch-for-today', function () {

    $execute = Artisan::call('app:fetch-news-and-article');

    return 'fresh-install done!';

});

Route::get('/', function () {
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
