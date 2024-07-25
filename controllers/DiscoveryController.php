<?php

class DiscoveryController extends AbstractController
{
    public function discovery(): void
    {
        $this->render("",[]);
    }
    
    public function listePlages(): void
    {
        
        
        //echo "listePlages";
        
        $pm = new PlagesManager();
        
        $plages = $pm->findAllPlages();
        
        $this->render("discovery/plages.html.twig",[
            "plages" =>$plages
            ]);
    }
    
    public function listeRivers(): void
    {
        //echo "listeRivers";
        
        $rm = new RiversManager();
        
        $rivers = $rm->findAllRivers();
        
        $this->render("discovery/rivers.html.twig",[
            "rivers" =>$rivers
            ]);
    }
    
    public function listeRestaurants(): void
    {
        //echo "listeRestaurants";
        
        $rtm = new RestaurantsManager();
        
        $restaurants = $rtm->findAllRestaurants();
        
        $this->render("discovery/restaurants.html.twig",[
            "restaurants" =>$restaurants
            ]);
    }
    
    public function listeHikes(): void
    {
        //echo "listeHikes";
        
        $hm = new HikesManager();
        
        $hikes = $hm->findAllHikes();
        
        $this->render("discovery/hikes.html.twig",[
            "hikes"=>$hikes
            ]);
    }
}