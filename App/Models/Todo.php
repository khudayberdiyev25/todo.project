<?php

namespace App\Models;

use Core\Model;
use PDO;

class Todo extends Model
{
    /**
     * Get all todos
     *
     * @return array
     */
    public static function getAllTodos() {

        $db = static::getDB();
        $sql = $db->query('SELECT * FROM todos');

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Create todo endpoint
     *
     * @param $email
     * @param $name
     * @param $text
     * @return string
     */
    public function createTodo($email, $name, $text)
    {
        if (!empty($email) || !empty($name) || !empty($text)) {

            $db = static::getDB();
            $sql = $db->query("INSERT INTO todos (`email`, `name`, `text`) VALUES ('$email', '$name', '$text')");

            return '';
        }

        return 'Something went wrong';
    }

    /**
     * Updates existing todo
     *
     * @param $id
     * @param $email
     * @param $name
     * @param $text
     * @param $status
     * @return string
     */
    public function updateTodo($id, $email, $name, $text, $status)
    {
        if (!empty($email) || !empty($name) || !empty($text) || !empty($status)) {
            $db = static::getDB();
            $sql = $db->query("UPDATE todos SET email = '$email', name='$name', text='$text', status='$status' WHERE id='$id'");
            return 'Updated successfully';
        }

        return 'Something went wrong';
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function findById($id)
    {
        $db = static::getDB();
        $sql = $db->query("SELECT * FROM todos WHERE id='$id'");

        return $sql->fetch(PDO::FETCH_ASSOC);
    }
}