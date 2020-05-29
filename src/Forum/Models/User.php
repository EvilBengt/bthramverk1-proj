<?php

namespace EVB\Forum\Models;

class User
{
    private $email;
    private $displayName;
    private $passwordHash;
    private $bio;
    private $id;

    public function __construct($email, $displayName, $passwordHash, $bio, $id)
    {
        $this->email = $email;
        $this->displayName = $displayName;
        $this->passwordHash = $passwordHash;
        $this->bio = $bio;
        $this->id = $id;
    }

    public function getEmail() : string
    {
        return $this->email;
    }

    public function getDisplayName()
    {
        return $this->displayName;
    }

    public function getName() : string
    {
        if ($this->displayName != null) {
            return $this->displayName;
        }
        return $this->email;
    }

    public function getPasswordHash() : string
    {
        return $this->passwordHash;
    }

    public function getBio()
    {
        return $this->bio;
    }

    public function checkPassword($password) : bool
    {
        return \password_verify($password, $this->passwordHash);
    }

    public function getID() : int
    {
        return $this->id;
    }

    public function getImageLink(int $size = 40) : string
    {
        $emailHash = \md5(\strtolower(\trim($this->email)));

        return "http://www.gravatar.com/avatar/" . $emailHash . "?d=retro&s=" . $size;
    }
}
