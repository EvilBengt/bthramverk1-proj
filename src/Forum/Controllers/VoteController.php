<?php

namespace EVB\Forum\Controllers;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;


class VoteController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;


    public function questionActionPost($id) : object
    {
        $request = $this->di->get("request");
        $response = $this->di->get("response");
        $questionManager = $this->di->get("questionManager");
        $session = $this->di->get("session");
        $userManager = $this->di->get("userManager");

        if (!$session->get("loggedIn", false)) {
            return $response->redirect("users/login");
        }

        if ($session->get("userID") == $questionManager->byID($id)->getAuthor()->getID()) {
            return $response->redirect("questions/view/" . $id);
        }

        $vote = \htmlentities($request->getPost("vote"));


        if ($vote == "up") {
            $questionManager->voteUp($id);
        } else if ($vote == "down") {
            $questionManager->voteDown($id);
        }

        $userManager->registerVote($session->get("userID"));

        return $response->redirect("questions/view/" . $id);
    }

    public function answerActionPost($id) : object
    {
        $request = $this->di->get("request");
        $response = $this->di->get("response");
        $answerManager = $this->di->get("answerManager");
        $session = $this->di->get("session");
        $userManager = $this->di->get("userManager");

        if (!$session->get("loggedIn", false)) {
            return $response->redirect("users/login");
        }

        if ($session->get("userID") == $answerManager->byID($id)->getAuthor()->getID()) {
            return $response->redirect("questions/view/" . $questionID . "#a" . $id);
        }

        $vote = \htmlentities($request->getPost("vote"));

        if ($vote == "up") {
            $answerManager->voteUp($id);
        } else if ($vote == "down") {
            $answerManager->voteDown($id);
        }

        $questionID = $answerManager->byID($id)->getQuestionID();

        $userManager->registerVote($session->get("userID"));

        return $response->redirect("questions/view/" . $questionID . "#a" . $id);
    }

    public function commentActionPost($id) : object
    {
        $request = $this->di->get("request");
        $response = $this->di->get("response");
        $commentManager = $this->di->get("commentManager");
        $session = $this->di->get("session");
        $userManager = $this->di->get("userManager");

        if (!$session->get("loggedIn", false)) {
            return $response->redirect("users/login");
        }

        if ($session->get("userID") == $commentManager->byID($id)->getAuthor()->getID()) {
            return $response->redirect("questions/view/" . $session->get("lastViewedQuestion") . "#c" . $id);
        }

        $vote = \htmlentities($request->getPost("vote"));

        if ($vote == "up") {
            $commentManager->voteUp($id);
        } else if ($vote == "down") {
            $commentManager->voteDown($id);
        }

        $userManager->registerVote($session->get("userID"));

        return $response->redirect("questions/view/" . $session->get("lastViewedQuestion") . "#c" . $id);
    }
}
