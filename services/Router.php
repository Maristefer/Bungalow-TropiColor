<?php

class Router 
{
    private ActivityController $ac;
    
    
    public function __construct()
    {
        $this->dc = new DiscoveryController();
    }
    
    public function handleRequest(array $get): void
    {
        if(!isset($get["route"]))
        {
            //home();
        }
        else if(isset($get["route"]) && $get["route"] === "home")
        {
             //$this->pc->home(); 
        }
        else if(isset($get["route"]) && $get["route"] === "discovery")
        {
            $this->dc->discovery();
        }
        else if(isset($get["route"]) && $get["route"] === "discovery_beach")
        {
            $this->dc->listePlages();
        }
        else if(isset($get["route"]) && $get["route"] === "discovery_rivers")
        {
            $this->dc->listeRivers();
        }
        else if(isset($get["route"]) && $get["route"] === "discovery_restaurants")
        {
            $this->dc->listeRestaurants();
        }
    }
}