<?php
/**
 * Supply the basis for the navbar as an array.
 */

global $di;
$loggedIn = $di->get("session")->get("loggedIn", false);

return [
    // Use for styling the menu
    "class" => "my-navbar",

    // Here comes the menu items/structure
    "items" => [
        [
            "text" => "Home",
            "url" => "",
            "title" => "The homepage, duh.",
        ],
        [
            "text" => "Questions",
            "url" => "questions",
            "title" => "Overview of all questions."
        ],
        [
            "text" => "Tags",
            "url" => "tags",
            "title" => "Overview of all tags."
        ],
        [
            "text" => $loggedIn ? "Me" : "Log in",
            "url" => "users",
            "title" => "Log in or view your profile.",
            "submenu" => $loggedIn ? [
                "items" => [
                    [
                        "text" => "Log out",
                        "url" => "users/logout",
                        "title" => "Log out from your account."
                    ]
                ]
            ] : [
                "items" => [
                    [
                        "text" => "Sign up",
                        "url" => "users/signup",
                        "title" => "Create an account."
                    ]
                ]
            ]
        ],
        [
            "text" => "About",
            "url" => "about",
            "title" => "About this project.",
        ],
    ],
];
