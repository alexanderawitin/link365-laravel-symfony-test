<?php

namespace App\Http\Controllers;

use File;

class HomeController extends Controller
{
    public function index()
    {
        $indexHtmlPath = public_path() . '/index.html';

        if (File::exists($indexHtmlPath)) {
            return response()->file($indexHtmlPath);
        }

        return response('Please run "ng build --prod" from "resources/frontend" directory first.', 500);
    }
}
