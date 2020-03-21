<?php

namespace App\Controllers;

use App\Models\Todo;
use Core\Controller;
use Core\View;

class Admin extends Controller
{
    /**
     * Admin dashboard endpoint
     */
    public function dashboardAction()
    {
        session_start();

        if (!$_SESSION['loggedIn']) {
            header('location: /login');
        }

        $allTodos = Todo::getAllTodos();
        arsort($allTodos);

        return View::renderTemplate('Admin/dashboard.html.twig', [
            'user' => $_SESSION['email'],
            'todos' => $allTodos
        ]);
    }

    /**
     * Edit existing todo endpoint
     *
     * @param Todo|null $todo
     */
    public function editAction()
    {
        session_start();

        if (!$_SESSION['loggedIn']) {
            header('location: /login');
        }


        $id = $this->routeParams['id'];
        $todo = Todo::findById($id);
        $errors = [];
        if (!empty($todo)){

            if (isset($_POST['editTodo'])) {

                $email = $_POST['email'];
                $name = $_POST['name'];
                $text = $_POST['text'];
                $status = $_POST['status'];

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

                if ($status === '--select--') {
                    array_push($errors, 'select the status');
                }

                if (!$errors) {
                    $todo = new Todo();

                    $request = $todo->updateTodo($id, $email, $name, $text, $status);

                    if ($request === 'Updated successfully') {
                        header('location: /admin');
                    }
                }
            }
        }

        return View::renderTemplate('Admin/edit.html.twig', [
            'todo' => $todo,
            'user' => $_SESSION['email'],
            'errors' => $errors,
        ]);
    }
}