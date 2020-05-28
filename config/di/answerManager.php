<?php
/**
 * AnswerManager DI config.
 */
return [
    "services" => [
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
    ],
];
