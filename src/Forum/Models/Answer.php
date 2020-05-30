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
    private $accepted;


    public function __construct($id, $question, $body, $comments, $commentContainerID, $author, $rating, $accepted)
    {
        $this->id = $id;
        $this->question = $question;
        $this->body = $body;
        $this->comments = $comments;
        $this->commentContainerID = $commentContainerID;
        $this->author = $author;
        $this->rating = $rating;
        $this->accepted = $accepted;
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

    public function getAccepted() : bool
    {
        return $this->accepted;
    }
}
