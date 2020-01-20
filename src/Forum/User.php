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
}
