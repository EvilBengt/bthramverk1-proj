<?php

namespace EVB\Forum\Controllers;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

use EVB\Forum\Question;
use EVB\Forum\Comment;


class QuestionController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;


    public function initialize() : void
    {
        $this->db = "active";
    }


    public function indexAction() : object
    {
        $page = $this->di->get("page");
        $dbqb = $this->di->get("dbqb");

        $question = new Question();
        $question->setDb($dbqb);

        $questions = $question->findAll();

        $page->add("forum/questions/overview", [
            "questions" => $questions
        ]);

        return $page->render([
            "title" => "Questions"
        ]);
    }

    public function viewAction($id) : object
    {
        $page = $this->di->get("page");
        $dbqb = $this->di->get("dbqb");
        $textfilter = $this->di->get("textfilter");

        $question = new Question();
        $question->setDb($dbqb);
        $question->findById($id);

        $question->body = $textfilter->markdown($question->body);
        $question->loadAuthor();
        $question->loadComments();
        $question->loadAnswers();

        $page->add("forum/questions/view", [
            "question" => $question
        ]);

        return $page->render([
            "title" => $question->title
        ]);
    }

    public function askActionGet() : object
    {
        $page = $this->di->get("page");

        $page->add("forum/questions/form");

        return $page->render([
            "title" => "Ask a question"
        ]);
    }
}
