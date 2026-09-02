<?php

namespace Http\Controllers;

class IndexController
{
    public function index()
    {
        return view('index.view.php', [
            'content' => 'Welcome to Talabat!',
        ]);
    }
}
