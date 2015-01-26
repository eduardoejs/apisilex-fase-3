<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);
date_default_timezone_set('America/Sao_Paulo');

require_once __DIR__.'/../vendor/autoload.php';

$app = new \Silex\Application();
$app['debug'] = true;//habilita debug mode

//registrando o twig
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views'
));

//registrando o URL Generator
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());