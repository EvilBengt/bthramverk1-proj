<?php

namespace EVB\Forum\Controllers;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;


class TagController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;


    public function indexAction() : object
    {
        $page = $this->di->get("page");
        $tagManager = $this->di->get("tagManager");

        $tags = $tagManager->all();

        $page->add("forum/tags/overview", [
            "tags" => $tags
        ]);

        return $page->render([
            "title" => "Tags"
        ]);
    }

    public function createActionPost() : object
    {
        $request = $this->di->get("request");
        $response = $this->di->get("response");
        $tagManager = $this->di->get("tagManager");

        $tagManager->create(\htmlentities($request->getPost("name")));

        return $response->redirect("tags");
    }
}
