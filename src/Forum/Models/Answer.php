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


    public function __construct($id, $question, $body, $comments, $commentContainerID, $author)
    {
        $this->id = $id;
        $this->question = $question;
        $this->body = $body;
        $this->comments = $comments;
        $this->commentContainerID = $commentContainerID;
        $this->author = $author;
    }


    public function getID() : int
    {
        return $this->id;
    }

    public function getQuestion() : Question
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
}
