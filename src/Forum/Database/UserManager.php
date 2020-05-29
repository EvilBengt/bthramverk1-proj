<?php

namespace EVB\Forum\Database;

use Anax\Database\Database;
use Anax\TextFilter\TextFilter;
use EVB\Forum\Models\User;

class UserManager
{
    /**
     * Database connection
     *
     * @var Database
     */
    private $db;

    /**
     * Text filter
     *
     * @var TextFilter
     */
    private $textFilter;


    public function __construct(Database $db, TextFilter $textFilter) {
        $this->db = $db;
        $this->textFilter = $textFilter;
    }


    public function byEmail(string $email) : User
    {
        $data = $this->db->connect()->executeFetch("
            SELECT email,
                   display_name,
                   password_hash,
                   bio,
                   reputation,
                   id
              FROM users
             WHERE email = ?
            ;
        ", [$email]);

        return $this->fromDbData($data);
    }

    public function hottest(int $count = 5) : array
    {
        $data = $this->db->connect()->executeFetchAll("
            SELECT email,
                   display_name,
                   password_hash,
                   bio,
                   reputation,
                   id
              FROM users
             ORDER BY reputation DESC
             LIMIT ?
            ;
        ", [$count]);

        foreach ($data as $key => $u) {
            $data[$key] = $this->fromDbData($u);
        }

        return $data;
    }

    public function byID(int $id) : User
    {
        $data = $this->db->connect()->executeFetch("
            SELECT email,
                   display_name,
                   password_hash,
                   bio,
                   reputation,
                   id
              FROM users
             WHERE id = ?
            ;
        ", [$id]);

        return $this->fromDbData($data);
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


    private function fromDbData(array $data) : User
    {
        return new User(
            $this->textFilter,
            $data["email"],
            $data["display_name"],
            $data["password_hash"],
            $data["bio"],
            $data["reputation"],
            $data["id"]
        );
    }
}
