<?php

class RestaurantsManager extends AbstractManager
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function findAllRestaurants(): array
    {
        $restaurants = [];
        
        $query = $this->db->prepare("SELECT * FROM restaurants");
        $query->execute();

        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $item) 
        {
            $restaurant = new Restaurants(
                $item["nom"],
                $item["typeCuisine"],
                $item["distance"],
                $item["commun"],
                $item["siteWeb"]
            );
            $restaurant->setId($item["id"]);

            $restaurants[] = $restaurant;
        }

        return  $restaurants;
    }
    
}