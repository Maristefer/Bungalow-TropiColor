<?php

class RiversManager extends AbstractManager
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function findAllRivers(): array
    {
        $rivers = [];
        
        $query = $this->db->prepare("SELECT * FROM rivieres");
        $query->execute();

        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $item) 
        {
            $river = new Rivers(
                $item["nom"],
                $item["description"],
                $item["distance"],
                $item["commun"],
                $item["url_localisation"]
            );
            $river->setId($item["id"]);

            $rivers[] = $river;
        }

        return $rivers;
    }
    
}