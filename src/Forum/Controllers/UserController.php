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
                "username" => $session->getOnce("username", ""),
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

        $username = $request->getPost("username", "");
        $password = $request->getPost("password");

        $session->set("username", $username);

        $user = $userManager->byUsername($username);

        if ($user != null && $user->checkPassword($password)) {
            $session->set("loggedIn", true);
        } else {
            $session->set("loginError", "Incorrect username and/or password");
        }

        return $response->redirect("users");
    }

    public function logoutAction() : object
    {
        $session = $this->di->get("session");
        $response = $this->di->get("response");

        $session->delete("username");
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

        $user = $userManager->instantiate(
            $request->getPost("username", ""),
            $request->getPost("password", "")
        );

        try {
            $userManager->save($user);
            $session->set("username", $user->getUsername());
            return $response->redirect("users");
        } catch (\Exception $e) {
            $session->set("signupError", "Something went wrong, username may already exist.");
            return $response->redirect("users/signup");
        }
    }
}
