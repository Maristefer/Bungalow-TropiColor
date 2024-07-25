<?php

class ParksManager extends AbstractManager
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function findAllParks(): array
    {
        $parks = [];
        
        $query = $this->db->prepare("SELECT * FROM parcs");
        $query->execute();

        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $item) 
        {
            $park = new Parks(
                $item["nom"],
                $item["categorie"],
                $item["distance"],
                $item["commun"],
                $item["site"]
            );
            $park->setId($item["id"]);

            $parks[] = $park;
        }

        return $parks;
    }
    
}