<?php
/**
 * Forum.
 */
return [
    "routes" => [
        [
            "info" => "Forum pages.",
            "mount" => "questions",
            "handler" => "\EVB\Forum\Controllers\QuestionController",
        ],
        [
            "info" => "Tag browser.",
            "mount" => "tags",
            "handler" => "\EVB\Forum\Controllers\TagController",
        ],
        [
            "info" => "Comment actions.",
            "mount" => "comments",
            "handler" => "\EVB\Forum\Controllers\CommentController",
        ],
        [
            "info" => "Voting actions.",
            "mount" => "vote",
            "handler" => "\EVB\Forum\Controllers\VoteController"
        ],
        [
            "info" => "Home page.",
            "mount" => "",
            "handler" => "\EVB\Forum\Controllers\HomeController"
        ],
    ]
];
