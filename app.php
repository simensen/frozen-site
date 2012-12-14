<?php

$app = new Silex\Application();

$app->get('/', function() use($app) {
    return 'Hello I am the root page!';
});

return $app;
