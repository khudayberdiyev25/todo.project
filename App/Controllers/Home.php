<?php

namespace App\Controllers;

use App\Models\Todo;
use Core\Controller;
use \Core\View;

class Home extends Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {
        $errors = [];
        $success = null;
        if (isset($_POST['submitTodo'])) {
            $email = $_POST['email'];
            $name = $_POST['name'];
            $text = $_POST['text'];


            if (!$email) {
                array_push($errors, 'email is required');
            }
            if (!$name) {
                array_push($errors, 'name is required');
            }
            if (!$text) {
                array_push($errors, 'text is required');
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                array_push($errors, 'invalid email address');
            }

            if (!$errors) {
                $todo = new Todo();

                $request = $todo->createTodo($email, $name, $text);

                if ($request === '') {
                    $success = 'Created Successfully';

                    header('refresh: 1');
                }

            }
        }

        $allTodos = Todo::getAllTodos();
        arsort($allTodos);

        View::renderTemplate('Home/index.html.twig', [
            'errors' => $errors,
            'success' => $success,
            'todos' => $allTodos
        ]);
    }
}
