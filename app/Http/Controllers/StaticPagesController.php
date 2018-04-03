<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class StaticPagesController extends Controller
{
    //
    public function home() {
        $feed_item = [];
        if (Auth::check()) {
            $feed_item = Auth::user()->feed()->paginate(30);
        }
        return view('static_pages/home', compact('feed_item'));
    }


    public function help() {
        return view('static_pages/help');
    }

    public function about() {
        return view('static_pages/about');
    }
}
