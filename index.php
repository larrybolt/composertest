<?php
require('./vendor/autoload.php');

$is_dev = $_SERVER['HTTP_HOST'] == 'composertest.dev';

$app = new \Slim\Slim();

$app->add(new \Slim\Middleware\HttpBasicAuthentication([
    "secure" => !$is_dev, // disallow http when in production
    "users" => [
        "root" => "t00r",
        "user" => "passw0rd"
    ],
    "callback" => function ($arguments) use ($app) {
        $app->user = $arguments['user'];
    }
]));

$app->get('/hello/:name', function ($name) use ($app) {
    echo "Hello, $name";
    echo "<br>you are logged in as {$app->user}";
});
$app->get('/', function () use($app) {
    echo "HI {$app->user}";
});

$app->run();
