<?php

namespace EVB\Forum;

use Anax\DatabaseActiveRecord\ActiveRecordModel;

/**
 * A database driven model using the Active Record design pattern.
 */
class Answer extends ActiveRecordModel
{
    protected $tableName = "answers";


    public $id;
    public $question;
    public $body;
    public $comment_container;
    public $author;

    public $comments;
    public $authorObject;


    public function loadAuthor()
    {
        $user = new User();
        $user->setDb($this->db);

        $this->authorObject = $user->findById($this->author);
    }

    public function loadComments()
    {
        $comment = new Comment();
        $comment->setDb($this->db);

        $this->comments = $comment->findAllWhere("comment_container = ?", $this->comment_container);

        foreach ($this->comments as $comment) {
            $comment->setDb($this->db);
            $comment->loadAuthor();
        }
    }
}
