<?php

namespace EVB\Forum\Models;

class Question
{
    private $id;
    private $title;
    private $body;
    private $comments;
    private $commentContainerID;
    private $author;
    private $answers;
    private $tags;


    public function __construct($id, $title, $body, $comments, $commentContainerID, $author, $answers, $tags)
    {
        $this->id = $id;
        $this->title = $title;
        $this->body = $body;
        $this->comments = $comments;
        $this->commentContainerID = $commentContainerID;
        $this->author = $author;
        $this->answers = $answers;
        $this->tags = $tags;
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

    public function getCommentContainerID() : int
    {
        return $this->commentContainerID;
    }

    public function getAuthor() : User
    {
        return $this->author;
    }

    public function getAnswers() : array
    {
        return $this->answers;
    }

    public function getTags() : array
    {
        return $this->tags;
    }
}
