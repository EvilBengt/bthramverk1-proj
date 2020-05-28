<?php

namespace EVB\Forum\Models;

class Question
{
    private $id;
    private $title;
    private $body;
    private $comments;
    private $author;
    private $answers;


    public function __construct($id, $title, $body, $comments, $author, $answers)
    {
        $this->id = $id;
        $this->title = $title;
        $this->body = $body;
        $this->comments = $comments;
        $this->author = $author;
        $this->answers = $answers;
    }


    public function getID() : int
    {
        return $this->id;
    }

    public function getTitle() : string
    {
        return $this->title;
    }

    public function getBody() : string
    {
        return $this->body;
    }

    public function getComments() : array
    {
        return $this->comments;
    }

    public function getAuthor() : User
    {
        return $this->author;
    }


    public function getAnswers() : array
    {
        return $this->answers;
    }
}
