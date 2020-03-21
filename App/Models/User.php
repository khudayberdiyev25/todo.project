<?php

namespace App\Models;

use Core\Model;
use PDO;


class User extends Model
{
    /**
     * Checks email uniqueness
     *
     * @param $email
     * @return string
     */
    public function validateEmail($email)
    {
        if ($email != '') {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

                $db = static::getDB();
                $sql = $db->query("SELECT * FROM users WHERE email='" . $email . "'");

                $result = $sql->fetchAll(PDO::FETCH_ASSOC);
                if (count($result) > 0) {
                    return 'email exists';
                }

                return '';
            }

            return 'Not valid email';
        }

        return  'This value cannot be null';
    }

    /**
     * Creates the user
     *
     * @param $email
     * @param $password
     * @return string
     */
    public function createUser($email, $password)
    {
        if (!empty($email) || !empty($password)) {
            $passwordHash = md5($password);
            $createdAt = \time();
            $updatedAt = \time();

            $db = static::getDB();
            $sql = $db->query(
                "INSERT INTO users (email, password, created_at, updated_at) VALUES ('$email', '$passwordHash', '$createdAt', '$updatedAt')");

            return '';
        }

        return 'Something went wrong';
    }
}
