<?php

namespace EVB\Forum\Models;

class Answer
{
    private $id;
    private $question;
    private $body;
    private $comments;
    private $commentContainerID;
    private $author;
    private $rating;


    public function __construct($id, $question, $body, $comments, $commentContainerID, $author, $rating)
    {
        $this->id = $id;
        $this->question = $question;
        $this->body = $body;
        $this->comments = $comments;
        $this->commentContainerID = $commentContainerID;
        $this->author = $author;
        $this->rating = $rating;
    }


    public function getID() : int
    {
        return $this->id;
    }

    public function getQuestionID() : int
    {
        return $this->question;
    }

    public function getBody() : string
    {
        return $this->body;
    }

    public function getComments() : array
    {
        return $this->comments;
    }

    public function getCommentContainerID() : int
    {
        return $this->commentContainerID;
    }

    public function getAuthor() : User
    {
        return $this->author;
    }

    public function getRating() : int
    {
        return $this->rating;
    }
}
