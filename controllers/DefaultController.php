<?php

class DefaultController extends AbstractController
{
    public function __construct() {
        // j'appelle le constructeur de l'AbstractController pour lui permettre de charger Twig
        parent::__construct();
    }

    public function homePage() : void
    {
        $this->render("front/home.html.twig", []);
    }
    
    public function notFound() : void
    {
        $this->render("front/error404.html.twig", []);
    }
}