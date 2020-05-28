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
                return new EVB\Forum\Database\UserManager($this->get("db"));
            }
        ],
    ],
];
