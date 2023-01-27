<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/* |-------------------------------------------------------------------------- | API Routes |-------------------------------------------------------------------------- | | Here is where you can register API routes for your application. These | routes are loaded by the RouteServiceProvider within a group which | is assigned the "api" middleware group. Enjoy building your API! | */

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(["as" => "todo.", "prefix" => "/todo"], function () {
    Route::get("/", [\App\Http\Controllers\Api\ApiTodoController::class , "index"])->name("index");
    Route::post("/autocomplete", [\App\Http\Controllers\Api\ApiTodoController::class , "autocomplete"])->name("autocomplete");
    Route::post("/", [\App\Http\Controllers\Api\ApiTodoController::class , "save"])->name("save");
    Route::put("/{id}", [\App\Http\Controllers\Api\ApiTodoController::class , "edit"])->name("edit");
    Route::get("/{id}", [\App\Http\Controllers\Api\ApiTodoController::class , "getOne"])->name("get");
    Route::delete("/{id}", [\App\Http\Controllers\Api\ApiTodoController::class , "delete"])->name("delete");
});