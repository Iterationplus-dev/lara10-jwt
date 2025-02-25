<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post("/register",[AuthController::class,"register"])->name('register');
Route::post("/login",[AuthController::class,"login"])->name('login');

Route::group(["middleware" => ["auth:api"]], function(){
   Route::get("/profile",[AuthController::class, 'profile'])->name("profile");
   Route::get("/refresh",[AuthController::class, 'refreshToken'])->name("refresh");
   Route::get("/logout",[AuthController::class, 'logout'])->name("logout");
});


