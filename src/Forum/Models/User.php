<?php

namespace EVB\Forum\Models;

use \Anax\TextFilter\TextFilter;

class User
{
    /**
     * Text filter
     *
     * @var TextFilter
     */
    private $textFilter;

    private $email;
    private $displayName;
    private $passwordHash;
    private $bio;
    private $rep;
    private $id;
    private $votes;

    public function __construct(TextFilter $textFilter, $email, $displayName, $passwordHash, $bio, $rep, $id, $votes)
    {
        $this->textFilter = $textFilter;
        $this->email = $email;
        $this->displayName = $displayName;
        $this->passwordHash = $passwordHash;
        $this->bio = $bio;
        $this->rep = $rep;
        $this->id = $id;
        $this->votes = $votes;
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

    public function getBio(bool $parsed = false)
    {
        if ($this->bio != null && $parsed) {
            return $this->textFilter->markdown($this->bio);
        }
        return $this->bio;
    }

    public function getRep() : int
    {
        return $this->rep;
    }

    public function getID() : int
    {
        return $this->id;
    }

    public function getVotes() : int
    {
        return $this->votes;
    }

    public function getImageLink(int $size = 40) : string
    {
        $emailHash = \md5(\strtolower(\trim($this->email)));

        return "http://www.gravatar.com/avatar/" . $emailHash . "?d=retro&s=" . $size;
    }

    public function checkPassword($password) : bool
    {
        return \password_verify($password, $this->passwordHash);
    }
}
