<?php

namespace EVB\Forum\Controllers;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;


class CommentController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;


    public function createActionPost($id) : object
    {
        $request = $this->di->get("request");
        $response = $this->di->get("response");
        $session = $this->di->get("session");
        $userManager = $this->di->get("userManager");
        $commentManager = $this->di->get("commentManager");

        if (!$session->get("loggedIn", false)) {
            return $response->redirect("users");
        }

        $user = $userManager->byID($session->get("userID"));

        $commentID = $commentManager->create(
            $id,
            $request->getPost("body"),
            $user->getID()
        );

        return $response->redirect("questions/view/" . $session->get("lastViewedQuestion") . "#c" . $commentID);
    }
}
