<?php

namespace EVB\Forum\Controllers;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;


class HomeController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;


    public function indexAction() : object
    {
        $page = $this->di->get("page");
        $questionManager = $this->di->get("questionManager");
        $tagManager = $this->di->get("tagManager");

        $latestQuestions = $questionManager->latest();
        $hottestTags = $tagManager->hottest();

        $page->add("forum/home/home", [
            "latestQuestions" => $latestQuestions,
            "hottestTags" => $hottestTags
        ]);

        return $page->render([
            "title" => "Home"
        ]);
    }
}
