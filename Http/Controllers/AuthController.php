<?php

namespace Http\Controllers;

use Core\Session;
use Http\Forms\RegistrationForm;
use Models\User;

class AuthController
{
    public function login()
    {
        view('login.view.php');
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
}
