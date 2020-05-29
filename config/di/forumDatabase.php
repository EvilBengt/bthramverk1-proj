<?php
/**
 * Configuration file for forum database services.
 */
return [
    // Services to add to the container.
    "services" => [
        "userManager" => [
            "shared" => true,
            "callback" => function () {
                return new EVB\Forum\Database\UserManager(
                    $this->get("db"),
                    $this->get("textfilter")
                );
            }
        ],
        "questionManager" => [
            "shared" => true,
            "callback" => function () {
                return new EVB\Forum\Database\QuestionManager(
                    $this->get("db"),
                    $this->get("userManager"),
                    $this->get("commentManager"),
                    $this->get("answerManager"),
                    $this->get("textfilter"),
                    $this->get("tagManager")
                );
            }
        ],
        "tagManager" => [
            "shared" => true,
            "callback" => function () {
                return new EVB\Forum\Database\TagManager(
                    $this->get("db")
                );
            }
        ],
        "answerManager" => [
            "shared" => true,
            "callback" => function () {
                return new EVB\Forum\Database\AnswerManager(
                    $this->get("db"),
                    $this->get("userManager"),
                    $this->get("commentManager"),
                    $this->get("textfilter")
                );
            }
        ],
        "commentManager" => [
            "shared" => true,
            "callback" => function () {
                return new EVB\Forum\Database\CommentManager(
                    $this->get("db"),
                    $this->get("userManager"),
                    $this->get("textfilter")
                );
            }
        ],
    ],
];
