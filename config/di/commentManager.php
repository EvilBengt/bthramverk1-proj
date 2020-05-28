<?php
/**
 * CommentManager DI config.
 */
return [
    "services" => [
        "commentManager" => [
            "shared" => true,
            "callback" => function () {
                return new EVB\Forum\Database\CommentManager(
                    $this->get("db"),
                    $this->get("userManager")
                );
            }
        ],
    ],
];
