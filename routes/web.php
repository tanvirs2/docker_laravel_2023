<?php

namespace App\Http\Controllers;
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

Route::get('/', function () {
    /*$selectedSourceArr = [];
    $selectedSourceArr[] = 'tanvir';
    $selectedSourceArr[] = 'nasir';

    dump(json_decode(json_encode($selectedSourceArr)));*/


    return ['Laravel' => app()->version()];
});

Route::resource('scrapping', NewsAndArticleController::class)
    //->middleware(['auth:sanctum'])
;

Route::resource('personalize-profile', PersonalizeProfileController::class);
Route::resource('news-source', NewsSourceController::class);


require __DIR__.'/auth.php';
