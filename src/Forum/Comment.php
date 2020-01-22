<?php

namespace EVB\Forum;

use Anax\DatabaseActiveRecord\ActiveRecordModel;

/**
 * A database driven model using the Active Record design pattern.
 */
class Comment extends ActiveRecordModel
{
    protected $tableName = "comments";


    public $id;
    public $comment_container;
    public $author;
    public $body;

    public $authorObject;
    

    public function loadAuthor()
    {
        $user = new User();
        $user->setDb($this->db);

        $this->authorObject = $user->findById($this->author);
    }
}
