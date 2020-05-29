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
        $page = $this->di->get("page");

        if ($session->get("loggedIn", false)) {
            $page->add("forum/users/overview");
        } else {
            $page->add("forum/users/login", [
                "email" => $session->getOnce("email", ""),
                "error" => $session->getOnce("loginError", "")
            ]);
        }

        return $page->render([
            "title" => "Users"
        ]);
    }

    public function loginActionPost() : object
    {
        $request = $this->di->get("request");
        $response = $this->di->get("response");
        $session = $this->di->get("session");
        $userManager = $this->di->get("userManager");

        $email = $request->getPost("email", "");
        $password = $request->getPost("password");

        $session->set("email", $email);

        $user = $userManager->byEmail($email);

        if ($user != null && $user->checkPassword($password)) {
            $session->set("loggedIn", true);
        } else {
            $session->set("loginError", "Incorrect email and/or password");
        }

        return $response->redirect("users");
    }

    public function logoutAction() : object
    {
        $session = $this->di->get("session");
        $response = $this->di->get("response");

        $session->delete("email");
        $session->delete("loggedIn");

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
                $request->getPost("email", ""),
                $request->getPost("password", "")
            );
            $session->set("email", $user->getEmail());
            return $response->redirect("users");
        } catch (\Exception $e) {
            $session->set("signupError", "Something went wrong, email may already be in use.");
            return $response->redirect("users/signup");
        }
    }
}
