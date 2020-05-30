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

        $vote = $request->getPost("vote");

        if ($vote == "up") {
            $questionManager->voteUp($id);
        } else if ($vote == "down") {
            $questionManager->voteDown($id);
        }

        return $response->redirect("questions/view/" . $id);
    }

    public function answerActionPost($id) : object
    {
        $request = $this->di->get("request");
        $response = $this->di->get("response");
        $answerManager = $this->di->get("answerManager");
        $questionManager = $this->di->get("questionManager");

        $vote = $request->getPost("vote");

        if ($vote == "up") {
            $answerManager->voteUp($id);
        } else if ($vote == "down") {
            $answerManager->voteDown($id);
        }

        $questionID = $answerManager->byID($id)->getQuestionID();

        return $response->redirect("questions/view/" . $questionID . "#a" . $id);
    }

    public function commentActionPost($id) : object
    {
        $request = $this->di->get("request");
        $response = $this->di->get("response");
        $commentManager = $this->di->get("commentManager");
        $session = $this->di->get("session");

        $vote = $request->getPost("vote");

        if ($vote == "up") {
            $commentManager->voteUp($id);
        } else if ($vote == "down") {
            $commentManager->voteDown($id);
        }

        return $response->redirect("questions/view/" . $session->get("lastViewedQuestion") . "#c" . $id);
    }
}
