<?php
/**
 * QuestionManager DI config.
 */
return [
    "services" => [
        "questionManager" => [
            "shared" => true,
            "callback" => function () {
                return new EVB\Forum\Database\QuestionManager(
                    $this->get("db"),
                    $this->get("userManager"),
                    $this->get("commentManager"),
                    $this->get("answerManager"),
                    $this->get("textfilter")
                );
            }
        ],
    ],
];
