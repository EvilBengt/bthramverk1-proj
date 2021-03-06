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

        $questions = [];
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
        $request = $this->di->get("request");
        $page = $this->di->get("page");
        $questionManager = $this->di->get("questionManager");
        $session = $this->di->get("session");

        $session->set("lastViewedQuestion", $id);

        $question = $questionManager->byID($id);

        $sortByRating = false;
        switch ($request->getGet("sort")) {
            case "rating":
                $session->set("answerSortOrder", "rating");
                $sortByRating = true;
                break;

            case "date":
                $session->set("answerSortOrder", "date");

            default:
                $sortByRating = $session->get("answerSortOrder", "date") == "rating";
                break;
        }

        if ($sortByRating) {
            $question->sortAnswersByRating();
        }

        $page->add("forum/questions/view", [
            "question" => $question,
            "isMyQuestion" => $session->get("loggedIn", false) && $session->get("userID") == $question->getAuthor()->getID(),
            "sortByRating" => $sortByRating,
            "myID" => $session->get("userID")
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

        $user = $userManager->byID($session->get("userID"));

        $questionTitle = \htmlentities($request->getPost("title"));
        $questionBody = \htmlentities($request->getPost("body"));
        $questionTags = [];
        foreach ($request->getPost("tags", []) as $tag) {
            $questionTags[] = \htmlentities($tag);
        }

        $questionID = $questionManager->create(
            $questionTitle,
            $questionBody,
            $user->getID(),
            $questionTags
        );

        return $response->redirect("questions/view/" . $questionID);
    }

    public function answerActionPost($id) : object
    {
        $request = $this->di->get("request");
        $response = $this->di->get("response");
        $session = $this->di->get("session");
        $userManager = $this->di->get("userManager");
        $answerManager = $this->di->get("answerManager");

        if (!$session->get("loggedIn", false)) {
            return $response->redirect("users");
        }

        $user = $userManager->byID($session->get("userID"));

        $answerBody = \htmlentities($request->getPost("body"));

        $answerID = $answerManager->create(
            $id,
            $answerBody,
            $user->getID()
        );

        return $response->redirect("questions/view/" . $id . "#a" . $answerID);
    }

    public function acceptAnswerActionPost() : object
    {
        $request = $this->di->get("request");
        $response = $this->di->get("response");
        $session = $this->di->get("session");
        $answerManager = $this->di->get("answerManager");
        $questionManager = $this->di->get("questionManager");

        $answer = $answerManager->byID($request->getPost("answer"));
        $question = $questionManager->byID($answer->getQuestionID());

        if ($session->get("loggedIn", false) && $session->get("userID") == $question->getAuthor()->getID()) {
            $answerManager->accept($answer->getID());
        }

        return $response->redirect("questions/view/" . $question->getID() . "#a" . $answer->getID());
    }
}
