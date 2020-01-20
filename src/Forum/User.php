<?php

namespace EVB\Forum;

use Anax\DatabaseActiveRecord\ActiveRecordModel;

/**
 * A database driven model using the Active Record design pattern.
 */
class User extends ActiveRecordModel
{
    protected $tableName = "users";


    public $id;
    public $username;
    public $password_hash;


    public function checkPassword(string $password) : bool
    {
        return \password_verify($password, $this->password_hash);
    }

    public function setPassword(string $password)
    {
        $this->password_hash = \password_hash($password, \PASSWORD_DEFAULT);
    }
}
