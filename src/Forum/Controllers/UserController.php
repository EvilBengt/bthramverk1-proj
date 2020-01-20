<?php

namespace EVB\Forum\Controllers;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

use EVB\Forum\User;


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
            $this->overviewPage($page);
        } else {
            $this->loginPage($page);
        }

        return $page->render([
            "title" => "NAME"
        ]);
    }

    public function loginActionPost() : object
    {
        $request = $this->di->get("request");
        $session = $this->di->get("session");

        $user = new User();
        
    }

    function loginPage(\Anax\Page\Page $page)
    {
        $page->add("forum/users/login");
    }

    function overviewPage(\Anax\Page\Page $page)
    {

    }
}
