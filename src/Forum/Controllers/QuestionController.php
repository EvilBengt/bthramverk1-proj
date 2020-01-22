<?php

namespace EVB\Forum\Controllers;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

use EVB\Forum\Question;
use EVB\Forum\QuestionWrapper;
use EVB\Forum\Comment;
use EVB\Forum\Tag;


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

        $question = new QuestionWrapper($dbqb);

        $question->model->findById($id);

        $question->model->body = $textfilter->markdown($question->model->body);
        $question->loadAuthor();
        $question->loadComments();
        $question->loadAnswers();

        $page->add("forum/questions/view", [
            "question" => $question
        ]);

        return $page->render([
            "title" => $question->model->title
        ]);
    }

    public function askActionGet() : object
    {
        $page = $this->di->get("page");
        $dbqb = $this->di->get("dbqb");

        $tag = new Tag();
        $tag->setDb($dbqb);
        $tags = $tag->findAll();

        $page->add("forum/questions/form", [
            "tags" => $tags
        ]);

        return $page->render([
            "title" => "Ask a question"
        ]);
    }

    public function askActionPost() : object
    {
        $request = $this->di->get("request");
        $response = $this->di->get("response");
        $dbqb = $this->di->get("dbqb");
        $session = $this->di->get("session");

        $question = new Question();
        $question->setDb($dbqb);

        $question->title = $request->getPost("title");
        $question->body = $request->getPost("body");

        $tags = $request->getPost("tags", []);

        $question->save();
        $question->saveTags($tags);
    }
}
