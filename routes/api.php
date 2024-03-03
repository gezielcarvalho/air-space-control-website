<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\RegisterController;

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

Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [RegisterController::class, 'login']);
Route::post('logout', [RegisterController::class, 'logout']);
Route::post('refresh', [RegisterController::class, 'refresh']);

Route::get('unprotected', function(){
    return response()->json(['message' => 'This is an unprotected route']);
});

Route::middleware('auth:api')->group(function(){
    Route::get('protected', function(){
        return response()->json(['message' => 'This is a protected route']);
    });
});
