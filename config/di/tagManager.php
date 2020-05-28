<?php
/**
 * AnswerManager DI config.
 */
return [
    "services" => [
        "tagManager" => [
            "shared" => true,
            "callback" => function () {
                return new EVB\Forum\Database\TagManager(
                    $this->get("db")
                );
            }
        ],
    ],
];
