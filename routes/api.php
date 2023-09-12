<?php

namespace App\Http\Controllers;
use App\Models\PersonalizeProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware(['auth:sanctum'])->get('/user-preference', function (Request $request) {
    //return PersonalizeProfile::where('user_id', Auth::id())->first(); sources
    $personalizeProfile = $request->user()->personalizeProfile;
    if ($personalizeProfile) {
        return [
            $personalizeProfile,
            json_decode($personalizeProfile->sources),
            json_decode($personalizeProfile->authors),
        ];
    }

    return null;
});

//Route::resource('personalize-profile', PersonalizeProfileController::class);

