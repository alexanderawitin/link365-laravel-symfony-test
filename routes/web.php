<?php

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
    $indexHtmlPath = public_path() . '/index.html';

    if (File::exists($indexHtmlPath)) {
        return response()->file($indexHtmlPath);
    }

    return response('Please run "ng build --prod" from "resources/frontend" directory first.', 500);
});
