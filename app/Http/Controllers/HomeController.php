<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController
{
    public function index() {
        $data['meta_title'] = 'Pembo-Mart';
        $data['meta_description'] = '';
        $data['meta_keywords'] = '';

        return view('home', $data);
    }
}
