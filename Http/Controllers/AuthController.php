<?php

namespace Http\Controllers;

class AuthController
{
    public function login()
    {
        view('login.view.php');
    }

    public function register()
    {
        view('register.view.php');
    }
}
