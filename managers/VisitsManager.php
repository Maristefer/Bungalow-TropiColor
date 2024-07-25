<?php

class VisitsManager extends AbstractManager
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function findAllVisits(): array
    {
        $visits = [];
        
        $query = $this->db->prepare("SELECT * FROM visites");
        $query->execute();

        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $item) 
        {
            $visit = new Visits(
                $item["nom"],
                $item["categorie"],
                $item["distance"],
                $item["commun"],
                $item["site"]
            );
            $visit->setId($item["id"]);

            $visits[] = $visit;
        }

        return $visits;
    }
    
}