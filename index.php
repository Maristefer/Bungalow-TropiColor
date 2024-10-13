<?php

// charge l'autoload de composer
require "vendor/autoload.php";

// charge le contenu du .env dans $_ENV
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

//Démarrage de session
session_start();

// générer un token CSRF 
if(!isset($_SESSION["csrf_token"]))
{
    $tokenManager = new CSRFTokenManager();
    $token = $tokenManager->generateCSRFToken();

    $_SESSION["csrf_token"] = $token;
}

// Initialisez la variable $route à null
$route = null;

// Si $_GET['route'] existe, donnez sa valeur à $route
if(isset($_GET['route']))
{
    $route=$_GET['route'];
}

// Instanciez le routeur et appelez la méthode handleRequest
$router = new Router();

$router->handleRequest($_GET);