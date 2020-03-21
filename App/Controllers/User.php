<?php

namespace App\Controllers;

use Core\Controller;
use Core\View;

class User extends Controller
{
    /**
     * User create
     */
    public function registerAction()
    {
        $errors = [];
        $user = new \App\Models\User();

        if (isset($_POST['register'])) {

            $email = $_POST['email'];
            $password = $_POST['password'];
            $verifyPassword = $_POST['verifyPassword'];

            if (!$email) {
                array_push($errors, 'email is required');
            }

            if (!$password) {
                array_push($errors, 'password is required');
            }

            if (!$verifyPassword) {
                array_push($errors, 'password verification is required');
            }

            if ($password !== $verifyPassword) {
                array_push($errors, 'invalid verification');
            }

            $validateEmail = $user->validateEmail($email);

            if ($validateEmail !== '') {
                array_push($errors, $validateEmail);
            }

            if (!$errors) {
                $request = $user->createUser($email, $password);

                if ($request == '') {

                    header('location: login');
                }

                array_push($errors, $request);
            }
        }

        return View::renderTemplate('User/register.html.twig', [
            'errors' => $errors
        ]);
    }

    /**
     * User login
     */
    public function loginAction()
    {
        $errors = [];
        if (isset($_POST['login'])) {
            session_start();

            $email = $_POST['email'];
            $password = $_POST['password'];

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                array_push($errors, 'Invalid email');
            }
            if (!$email) {
                array_push($errors, 'email is required');
            }

            if (!$password) {
                array_push($errors, 'password is required');
            }

            if ($email === 'admin@admin.com' && $password === '123') {

                session_regenerate_id();
                $_SESSION['loggedIn'] = true;
                $_SESSION['timeout'] = time();
                $_SESSION['email'] = 'admin@admin.com';

                header('location: admin');
            }

            array_push($errors, 'Wrong email or password');



        }

        return View::renderTemplate('User/login.html.twig', [
            'errors' => $errors
        ]);
    }

    /**
     * User logout
     */
    public function logout()
    {
        session_start();
        $_SESSION['loggedIn'] = false;

        header("Location: /");
    }
}