<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php';
require 'controller.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$myController = new controller;

$app = new \Slim\App;
$app->get('/', function (Request $request, Response $response) {
    $response->getBody()->write(file_get_contents('html/header.html') . file_get_contents('html/home.html'));
});
$app->get('/basics', function (Request $request, Response $response) {
    global $myController;
    $header = $myController->activeLink(file_get_contents('html/header.html'),"basics");
    $body = file_get_contents('html/basics.html');
    $response->getBody()->write($header. $body);
    return $response;
});
$app->get('/languages', function (Request $request, Response $response) {
    global $myController;
    $header = $myController->activeLink(file_get_contents('html/header.html'),"languages");
    $languages = file_get_contents('html/languages.html');
    $body = file_get_contents('html/body.html');
    $body = $myController->inputBody($body,$languages);
    $response->getBody()->write($header . $body );
});
$app->get('/algorithems', function (Request $request, Response $response) {
    global $myController;
    $header = $myController->activeLink(file_get_contents('html/header.html'),"algorithems");
    $response->getBody()->write($header . file_get_contents('html/body.html'));
});
$app->post('/maze/submit', function (Request $request, Response $response) {
    global $myController;

});
$app->run();