<?php

use App\Events\Started;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\TestController;
use App\Models\Test;

//use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use LasseRafn\InitialAvatarGenerator\InitialAvatar;

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

Auth::routes();


Route::get('/', function () {
    return view('welcome');
});

Route::get('/aaa', function () {
    event(new Started());
    return true;
});


Route::get('/test_create', function (Faker\Generator $faker) {
    return Test::query()
        ->insert([
            'name' => $faker->text(50),
            'user_id' => Auth::user()->getAuthIdentifier()
        ]);
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'test', 'middleware' => 'auth'], function () {
    Route::post('/in', [TestController::class, 'In']);
    Route::post('/out', [TestController::class, 'Out']);
    Route::get('/enter/{id}', [TestController::class, 'show']);
    Route::get('/create', [TestController::class, 'create']);
    Route::post('/store', [TestController::class, 'store']);
    Route::get('/variants', [TestController::class, 'variants']);
    Route::get('/get_test_with_details/{id}', [TestController::class, 'getTestWithDetails']);
//    Route::post()
});

Route::group(['prefix' => 'question', 'middleware' => 'auth'], function () {
    Route::post('/', [QuestionController::class, 'store']);
});

Route::get('/avatar', function () {
    $response = Http::withHeaders([
        'x-rapidapi-host' => 'get-avatar-from-string.p.rapidapi.com',
        'x-rapidapi-key' => '58e5ddbfbdmsh17d78406911846ap1f0fc9jsn37f9c1ce98d6'
    ])->get('https://get-avatar-from-string.p.rapidapi.com/avatar/Furqatmasda');
    dd($response->json()['avatar_svg']);
});
