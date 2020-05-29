<?php

namespace EVB\Forum\Database;

use Anax\Database\Database;
use EVB\Forum\Models\User;

class UserManager
{
    /**
     * Database connection
     *
     * @var Database
     */
    private $db;


    public function __construct(Database $db) {
        $this->db = $db;
    }


    public function byEmail(string $username) : User
    {
        $data = $this->db->connect()->executeFetch("
            SELECT email, display_name, password_hash, id
              FROM users
             WHERE email = ?
            ;
        ", [$username]);

        return new User($data["email"], $data["display_name"], $data["password_hash"], $data["id"]);
    }

    public function byID(int $id) : User
    {
        $data = $this->db->connect()->executeFetch("
            SELECT email, display_name, password_hash, id
              FROM users
             WHERE id = ?
            ;
        ", [$id]);

        return new User($data["email"], $data["display_name"], $data["password_hash"], $data["id"]);
    }

    public function create(string $email, string $password)
    {
        $this->db->connect()->execute("
            INSERT INTO users(email, password_hash)
            VALUES (?, ?)
            ;
        ", [
            $email,
            \password_hash($password, \PASSWORD_DEFAULT)
        ]);
    }
}
