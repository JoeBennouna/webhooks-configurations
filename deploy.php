<?php

use Dotenv\Dotenv;

if ($_SERVER['HTTP_HOST'] == getenv("DOMAIN_HOST") || $_SERVER['SERVER_NAME'] == getenv("DOMAIN_HOST")) {
    // I use Heroku for hosting wich doesnt require an environment vars library
} else {
    require_once(__DIR__ . '../../vendor/autoload.php');
      
    $dotenv  = Dotenv::createImmutable(__DIR__ . '\../');
    $dotenv->load();
}

// Send the message to discord
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, getenv("HEROKU_DISCORD_DEPLOYMENT_URL"));
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
    'content-type'   => "application/json",
    'content' => $output,
    'username' => $username,
    'avatar_url' => getenv("AVATAR_URL"),
]));

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

echo $data = curl_exec($ch);
curl_close($ch);