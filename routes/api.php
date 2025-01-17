<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\PostController;
use Illuminate\Support\Facades\Mail;


// Open Routes
Route::post("register", [ApiController::class, "register"]);
Route::post('verify-user', [ApiController::class, 'verifyEmail']);
Route::post("login", [ApiController::class, "login"]);

// Protected Routes
Route::group([
    "middleware" => ["auth:api"]
], function(){
    Route::get("profile", [ApiController::class, "profile"]);
    Route::get("refresh-token", [ApiController::class, "refreshToken"]);
    Route::get('user/{user_id}', [ApiController::class, 'getUser']);
    Route::get("logout", [ApiController::class, "logout"]);   
    
    Route::post('/posts', [PostController::class, 'create']);
    Route::get('/posts', [PostController::class, 'index']);
    Route::get('/posts/{id}', [PostController::class, 'show']);
    Route::put('/posts/{id}', [PostController::class, 'update']);
    Route::delete('/posts/{id}', [PostController::class, 'destroy']); 
    Route::get('/logs', [ApiController::class, 'getLogs']);

});
