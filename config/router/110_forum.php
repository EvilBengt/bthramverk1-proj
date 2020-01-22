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
    ]
];
