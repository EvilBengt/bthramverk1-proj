<?php

namespace EVB\Forum\Models;

class Comment
{
    private $id;
    private $commentContainer;
    private $author;
    private $body;


    public function __construct($id, $commentContainer, $author, $body)
    {
        $this->id = $id;
        $this->commentContainer = $commentContainer;
        $this->author = $author;
        $this->body = $body;
    }


    public function getID() : int
    {
        return $this->id;
    }

    public function getCommentContainer() : int
    {
        return $this->commentContainer;
    }

    public function getAuthor() : User
    {
        return $this->author;
    }

    public function getBody() : string
    {
        return $this->body;
    }
}
