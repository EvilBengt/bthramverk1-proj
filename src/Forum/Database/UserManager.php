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


    public function byEmail(string $email) : User
    {
        $data = $this->db->connect()->executeFetch("
            SELECT email,
                   display_name,
                   password_hash,
                   bio,
                   id
              FROM users
             WHERE email = ?
            ;
        ", [$email]);

        return new User($data["email"], $data["display_name"], $data["password_hash"], $data["bio"], $data["id"]);
    }

    public function byID(int $id) : User
    {
        $data = $this->db->connect()->executeFetch("
            SELECT email,
                   display_name,
                   password_hash,
                   bio,
                   id
              FROM users
             WHERE id = ?
            ;
        ", [$id]);

        return new User($data["email"], $data["display_name"], $data["password_hash"], $data["bio"], $data["id"]);
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

    public function update(int $id, string $email, string $displayName, string $password, string $bio)
    {
        if (!empty($password)) {
            $this->db->connect()->execute("
                UPDATE users
                   SET email         = ?,
                       display_name  = ?,
                       bio           = ?,
                       password_hash = ?
                 WHERE id = ?
            ", [
                $email,
                $displayName,
                $bio,
                \password_hash($password, \PASSWORD_DEFAULT),
                $id
            ]);
        } else {
            $this->db->connect()->execute("
                UPDATE users
                   SET email        = ?,
                       display_name = ?,
                       bio          = ?
                 WHERE id = ?
            ", [
                $email,
                $displayName,
                $bio,
                $id
            ]);
        }
    }
}