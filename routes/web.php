<?php

use App\Http\Middleware\VerifyCsrfToken;
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



/*
 *
 * User
 *
 *
 */

Route::get("/user",[\App\Http\Controllers\UserController::class,"user"])
    ->name("user.information")
    ->middleware("auth");

/*
 *
 * Game
 *
 */
Route::group(["prefix"=>"game",'middleware'=>"auth"],function (){
    Route::post("/find-game",[\App\Http\Controllers\GameController::class,"findGame"])->middleware([
        \App\Http\Middleware\IsPlayerOnline::class,
        \App\Http\Middleware\IsPlayerAlreadyInQueue::class,
        \App\Http\Middleware\HasPlayerAnyUnfinishedGame::class
    ])->name("game.find");
    Route::post("/accept-game/{game}",[\App\Http\Controllers\GameController::class,"acceptGame"])->middleware(
        [
            "can:acceptGame,game",
            \App\Http\Middleware\IsPlayerOnline::class,
            \App\Http\Middleware\HaveYouAcceptedGame::class,
            \App\Http\Middleware\IsEveryBodyReadyForStartGame::class
        ]
    )->name("game.accept");
});





/*
 * AUTH
 *
 */
Route::get("/csrf-token",function (\Illuminate\Http\Request  $request){
    $token = $request->session()->token();
    return response()->json([
        "data"=>[
            "token"=>$token
        ]
    ],200);
});
Route::post("/login",[\App\Http\Controllers\Auth\LoginController::class,"login"])->name("login");
Route::post("/logout",[\App\Http\Controllers\Auth\LoginController::class,"logout"])->name("logout");
Route::post("/register",[\App\Http\Controllers\Auth\RegisterController::class,"register"])->name("register");



/*
 *
 * Test
 *
 *
 */

Route::get("/test",function (\App\Card\CardDistributor $cardDistributor){
    return view("home");
});
