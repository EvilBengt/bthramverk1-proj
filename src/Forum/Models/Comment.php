<?php

namespace EVB\Forum\Models;

class Comment
{
    private $id;
    private $commentContainer;
    private $author;
    private $body;
    private $rating;


    public function __construct($id, $commentContainer, $author, $body, $rating)
    {
        $this->id = $id;
        $this->commentContainer = $commentContainer;
        $this->author = $author;
        $this->body = $body;
        $this->rating = $rating;
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

    public function getRating() : int
    {
        return $this->rating;
    }
}
