<?php

class HikesManager extends AbstractManager
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function findAllHikes(): array
    {
        $hikes = [];
        
        $query = $this->db->prepare("SELECT * FROM randonnees");
        $query->execute();

        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $item) 
        {
            $hike = new Hikes(
                $item["nom"],
                $item["commun"],
                $item["distance"],
                $item["duree"],
                $item["niveau"],
                $item["site"]
            );
            $hike->setId($item["id"]);

            $hikes[] = $hike;
        }

        return $hikes;
    }
    
}