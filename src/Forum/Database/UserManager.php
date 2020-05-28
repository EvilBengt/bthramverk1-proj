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


    public function byUsername(string $username) : User
    {
        $data = $this->db->connect()->executeFetch("
            SELECT username, password_hash, id
              FROM users
             WHERE username = ?
            ;
        ", [$username]);

        return new User($data["username"], $data["password_hash"], $data["id"]);
    }

    public function byID(int $id) : User
    {
        $data = $this->db->connect()->executeFetch("
            SELECT username, password_hash, id
              FROM users
             WHERE id = ?
            ;
        ", [$id]);

        return new User($data["username"], $data["password_hash"], $data["id"]);
    }

    public function instantiate(string $username, string $password) : User
    {
        return new User($username, \password_hash($password, \PASSWORD_DEFAULT));
    }

    public function save(User $user)
    {
        $this->db->connect()->execute("
            INSERT INTO users(username, password_hash)
            VALUES (?, ?)
            ;
        ", [$user->getUsername(), $user->getPasswordHash()]);
    }
}
