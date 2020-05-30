<?php

namespace EVB\Forum\Controllers;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;


class QuestionController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;


    public function indexAction() : object
    {
        $page = $this->di->get("page");
        $request = $this->di->get("request");
        $questionManager = $this->di->get("questionManager");

        $tag = $request->getGet("tag");

        $questions;
        if ($tag != null) {
            $questions = $questionManager->withTag($tag);
        } else {
            $questions = $questionManager->all();
        }


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
        $textfilter = $this->di->get("textfilter");
        $questionManager = $this->di->get("questionManager");
        $session = $this->di->get("session");

        $session->set("lastViewedQuestion", $id);

        $question = $questionManager->byID($id);

        $page->add("forum/questions/view", [
            "question" => $question
        ]);

        return $page->render([
            "title" => $question->getTitle()
        ]);
    }

    public function askActionGet() : object
    {
        $page = $this->di->get("page");
        $tagManager = $this->di->get("tagManager");
        $session = $this->di->get("session");
        $response = $this->di->get("response");

        if (!$session->get("loggedIn", false)) {
            return $response->redirect("users");
        }

        $tags = $tagManager->all();

        $page->add("forum/questions/ask", [
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
        $session = $this->di->get("session");
        $questionManager = $this->di->get("questionManager");
        $userManager = $this->di->get("userManager");

        if (!$session->get("loggedIn", false)) {
            return $response->redirect("users");
        }

        $user = $userManager->byEmail($session->get("email"));

        $questionID = $questionManager->create(
            $request->getPost("title"),
            $request->getPost("body"),
            $user->getID(),
            $request->getPost("tags", [])
        );

        return $response->redirect("questions/view/" . $questionID);
    }

    public function answerActionGet($id) : object
    {
        $page = $this->di->get("page");
        $session = $this->di->get("session");
        $response = $this->di->get("response");
        $questionManager = $this->di->get("questionManager");

        if (!$session->get("loggedIn", false)) {
            return $response->redirect("users");
        }

        $page->add("forum/questions/answer", [
            "question" => $questionManager->byID($id)
        ]);

        return $page->render([
            "title" => "Write your answer"
        ]);
    }

    public function answerActionPost($id) : object
    {
        $request = $this->di->get("request");
        $response = $this->di->get("response");
        $session = $this->di->get("session");
        $questionManager = $this->di->get("questionManager");
        $userManager = $this->di->get("userManager");
        $answerManager = $this->di->get("answerManager");

        if (!$session->get("loggedIn", false)) {
            return $response->redirect("users");
        }

        $user = $userManager->buID($session->get("userID"));

        $answerID = $answerManager->create(
            $id,
            $request->getPost("body"),
            $user->getID()
        );

        return $response->redirect("questions/view/" . $id . "#a" . $answerID);
    }
}
