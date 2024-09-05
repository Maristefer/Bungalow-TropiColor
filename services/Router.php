<?php

class Router 
{
    private DiscoveryController $dc;
    private BungalowsController $bc;
    private DefaultController $dfc;
    
    
    public function __construct()
    {
        $this->dc = new DiscoveryController();
        $this->bc = new BungalowsController();
        $this->dfc = new DefaultController();
    }
    
    public function handleRequest(array $get): void
    {
        if(!isset($get["route"]))
        {
            $this->dfc->homepage();
        }
        else if(isset($get["route"]) && $get["route"] === "home")
        {
             $this->dfc->homepage(); 
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
        else if(isset($get["route"]) && $get["route"] === "discovery_hikes")
        {
            $this->dc->listeHikes();
        }
         else if(isset($get["route"]) && $get["route"] === "discovery_parks")
        {
            $this->dc->listeParks();
        }
        else if(isset($get["route"]) && $get["route"] === "discovery_visits")
        {
            $this->dc->listeVisits();
        }
        else if(isset($get["route"]) && $get["route"] === "bungalows")
        {
            $this->bc->listeBungalows();
        }
    }
}