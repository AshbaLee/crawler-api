<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CrawlerController;


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

Route::apiResource('crawler', CrawlerController::class)->except(['update', 'destroy']);
