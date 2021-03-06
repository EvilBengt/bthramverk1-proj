<?php

namespace EVB\Forum\Controllers;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

use EVB\Forum\Model\User;


class UserController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;


    public function initialize() : void
    {
        $this->db = "active";
    }


    public function indexAction() : object
    {
        $session = $this->di->get("session");
        $response = $this->di->get("response");

        if ($session->get("loggedIn", false)) {
            return $response->redirect("users/me");
        }
        return $response->redirect("users/login");
    }

    public function meActionGet() : object
    {
        $session = $this->di->get("session");
        $page = $this->di->get("page");
        $response = $this->di->get("response");
        $userManager = $this->di->get("userManager");
        $questionManager = $this->di->get("questionManager");
        $answerManager = $this->di->get("answerManager");
        $commentManager = $this->di->get("commentManager");

        if (!$session->get("loggedIn", false)) {
            return $response->redirect("users/login");
        }

        $user = $userManager->byID($session->get("userID"));
        $questions = $questionManager->byUserID($user->getID());
        $answers = $answerManager->byUserID($user->getID());
        $comments = $commentManager->byUserID($user->getID());

        $answeredQuestions = [];
        foreach ($answers as $a) {
            $answeredQuestions[$a->getQuestionID()] = $questionManager->byID($a->getQuestionID());
        }

        $commentedQuestions = [];
        foreach ($comments as $c) {
            $questionID = $commentManager->getQuestionID($c->getID());
            $commentedQuestions[] = [
                "question" => $questionManager->byID($questionID),
                "comment" => $c
            ];
        }

        $page->add("forum/users/view", [
            "user" => $user,
            "asked" => $questions,
            "answers" => $answers,
            "answered" => $answeredQuestions,
            "commented" => $commentedQuestions,
            "showEditLink" => false
        ]);
        $page->add("forum/users/me", [
            "user" => $user
        ]);

        return $page->render([
            "title" => "Profile"
        ]);
    }

    public function meActionPost() : object
    {
        $session = $this->di->get("session");
        $request = $this->di->get("request");
        $response = $this->di->get("response");
        $userManager = $this->di->get("userManager");

        if (!$session->get("loggedIn", false)) {
            return $response->redirect("users/login");
        }

        $userManager->update(
            $session->get("userID"),
            $request->getPost("email"),
            $request->getPost("displayName"),
            $request->getPost("password"),
            $request->getPost("bio")
        );

        return $response->redirect("users/me");
    }

    public function loginActionGet() : object
    {
        $session = $this->di->get("session");
        $page = $this->di->get("page");
        $response = $this->di->get("response");

        if ($session->get("loggedIn", false)) {
            return $response->redirect("users/me");
        }

        $page->add("forum/users/login", [
            "email" => $session->getOnce("loginAttemptEmail", ""),
            "error" => $session->getOnce("loginError", "")
        ]);

        return $page->render([
            "title" => "Login"
        ]);
    }

    public function loginActionPost() : object
    {
        $request = $this->di->get("request");
        $response = $this->di->get("response");
        $session = $this->di->get("session");
        $userManager = $this->di->get("userManager");

        $email = \htmlentities($request->getPost("email"));
        $password = \htmlentities($request->getPost("password"));

        $user = $userManager->byEmail($email);

        if ($user != null && $user->checkPassword($password)) {
            $session->set("loggedIn", true);
            $session->set("userID", $user->getID());
        } else {
            $session->set("loginError", "Incorrect email and/or password");
            $session->set("loginAttemptEmail", $email);
        }

        return $response->redirect("users");
    }

    public function logoutAction() : object
    {
        $session = $this->di->get("session");
        $response = $this->di->get("response");

        $session->delete("loggedIn");
        $session->delete("userID");

        return $response->redirect("users");
    }

    public function signupActionGet() : object
    {
        $page = $this->di->get("page");
        $session = $this->di->get("session");

        $page->add("forum/users/signup", [
            "error" => $session->getOnce("signupError", "")
        ]);

        return $page->render([
            "title" => "Sign up"
        ]);
    }

    public function signupActionPost() : object
    {
        $request = $this->di->get("request");
        $response = $this->di->get("response");
        $session = $this->di->get("session");
        $userManager = $this->di->get("userManager");

        try {
            $userManager->create(
                \htmlentities($request->getPost("email", "")),
                \htmlentities($request->getPost("password", ""))
            );
            $session->set("email", $user->getEmail());
            return $response->redirect("users");
        } catch (\Exception $e) {
            $session->set("signupError", "Something went wrong, email may already be in use.");
            return $response->redirect("users/signup");
        }
    }

    public function viewAction($id) : object
    {
        $page = $this->di->get("page");
        $userManager = $this->di->get("userManager");
        $questionManager = $this->di->get("questionManager");
        $answerManager = $this->di->get("answerManager");
        $commentManager = $this->di->get("commentManager");
        $session = $this->di->get("session");

        $user = $userManager->byID($id);
        $questions = $questionManager->byUserID($id);
        $answers = $answerManager->byUserID($id);
        $comments = $commentManager->byUserID($id);

        $answeredQuestions = [];
        foreach ($answers as $a) {
            $answeredQuestions[$a->getQuestionID()] = $questionManager->byID($a->getQuestionID());
        }

        $commentedQuestions = [];
        foreach ($comments as $c) {
            $questionID = $commentManager->getQuestionID($c->getID());
            $commentedQuestions[] = [
                "question" => $questionManager->byID($questionID),
                "comment" => $c
            ];
        }

        $page->add("forum/users/view", [
            "user" => $user,
            "asked" => $questions,
            "answers" => $answers,
            "answered" => $answeredQuestions,
            "commented" => $commentedQuestions,
            "showEditLink" => $user->getID() == $session->get("userID", -1)
        ]);

        return $page->render([
            "title" => $user->getName()
        ]);
    }
}
