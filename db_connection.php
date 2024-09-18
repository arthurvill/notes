<?php
// config.php
return [
    'servername' => getenv('DB_HOST'),
    'username' => getenv('DB_USERNAME'),
    'password' => getenv('DB_PASSWORD'),
    'database' => getenv('DB_DATABASE'),
    'port'     => getenv('DB_PORT') ?: '3306'// Databse port, default to 3306 if not set
];
