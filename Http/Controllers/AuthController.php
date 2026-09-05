<?php

namespace Http\Controllers;

use Core\Session;
use Http\Forms\RegistrationForm;
use Http\Forms\LoginForm;
use Models\User;

class AuthController
{
    public function login()
    {
        view('login.view.php', [
            'errors' => Session::get('errors'),
            'old' => Session::get('old'),
        ]);
    }

    public function register()
    {
        view('register.view.php', [
            'errors' => Session::get('errors'),
            'old' => Session::get('old'),
        ]);
    }

    public function storeCustomer()
    {
        $form = RegistrationForm::attempt([
            'name' => $_POST['fullname'],
            'email' => $_POST['email'],
            'password' => $_POST['password'],
            'confirm-password' => $_POST['confirm-password'],
            'phone' => $_POST['phone'],
            'address' => $_POST['address'],
        ]);

        User::login($form->getUser());
        redirect('/customer/home');
    }

    public function storeSession()
    {
        $form = LoginForm::attempt([
            'email' => $_POST['email'],
            'password' => $_POST['password']
        ]);

        User::login($form->user());

        redirect('/customer/home');
    }
}
