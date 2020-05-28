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
    ]
];
