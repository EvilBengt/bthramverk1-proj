<?php

namespace EVB\Forum\Models;

class User
{
    private $username;
    private $passwordHash;
    private $id;

    public function __construct($username, $passwordHash, $id = -1)
    {
        $this->username = $username;
        $this->passwordHash = $passwordHash;
        $this->id = $id;
    }

    public function getUsername() : string
    {
        return $this->username;
    }

    public function getPasswordHash() : string
    {
        return $this->passwordHash;
    }

    public function checkPassword($password) : bool
    {
        return \password_verify($password, $this->passwordHash);
    }

    public function getID() : int
    {
        return $this->id;
    }
}
