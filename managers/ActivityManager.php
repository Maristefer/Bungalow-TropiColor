<?php

class ActivityManager extends AbstractManager
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function findAllPlages(): array
    {
        $plages = [];
        
        $query = $this->db->prepare("SELECT * FROM plages");
        $query->execute();

        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $item) 
        {
            $plage = new Plages(
                $item["nom"],
                $item["description"],
                $item["distance"],
                $item["commun"],
                $item["url_localisation"]
            );
            $plage->setId($item["id"]);

            $plages[] = $plage;
        }

        return $plages;
    }
    
}