<?php

class BungalowManager extends AbstractManager
{
    public function __construct()
    {
        parent::__construct();
    }
    
    // Créer un bungalow
    public function createBungalow(Bungalow $bungalow) : Bungalow
    {
        $query = $this->db->prepare('INSERT INTO bungalows (id, name, description, photo_id, capacity, price, car_id, surface) VALUES (NULL, :name, :description, :photo_id, :capacity, :price, :car_id, :surface)');
        $parameters = [
            "name" => $bungalow->getName(),
            "description" => $bungalow->getDescription(),
            "photo_id" => $bungalow->getPhoto_id(),
            "capacity" => $bungalow->getCapacity(),
            "price" => $bungalow->getPrice(),
            "car_id" => $bungalow->getCar_id(),
            "surface" => $bungalow->getSurface(),
        ];

        // Exécution de la requête SQL
        $query->execute($parameters);
        
        // Récupérer l'ID du dernier bungalow inséré
        $bungalow->setId($this->db->lastInsertId());

        return $bungalow;
    }

    //Récupère tous les bungalows
    public function findAllBungalows(): array
    {
        $bungalows = [];

        $query = $this->db->prepare("SELECT * FROM bungalows");
        $query->execute();

        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $item) {
            $bungalow = new Bungalow(
                $item["name"],
                $item["description"],
                $item["photo_id"],
                $item["capacity"],
                $item["price"],
                $item["car_id"],
                $item["surface"]
            );
            $bungalow->setId($item["id"]);

            $bungalows[] = $bungalow;
        }

        return $bungalows;
    }

    // Récupérer un bungalow par son ID
    public function findBungalowById(int $id): ? Bungalow
    {
        $query = $this->db->prepare("SELECT * FROM bungalows WHERE id = :id");
        $query->execute(['id' => $id]);

        $item = $query->fetch(PDO::FETCH_ASSOC);

        if ($item) {
            $bungalow = new Bungalow(
                $item["name"],
                $item["description"],
                $item["photo_id"],
                $item["capacity"],
                $item["price"],
                $item["car_id"],
                $item["surface"]
            );
            $bungalow->setId($item["id"]);

            return $bungalow;
        }

        return null;
    }    
    
    // Mettre à jour un bungalow
    public function updateBungalow(Bungalow $bungalow): Bungalow
    {
       $query = $this->db->prepare('
                UPDATE bungalows 
                SET name = :name, description = :description, photo_id = :photo_id, 
                capacity = :capacity, price = :price, car_id = :car_id, surface = :surface 
                WHERE id = :id'
            );
            $parameters = [
                "name" => $bungalow->getName(),
                "description" => $bungalow->getDescription(),
                "photo_id" => $bungalow->getPhoto_id(),
                "capacity" => $bungalow->getCapacity(),
                "price" => $bungalow->getPrice(),
                "car_id" => $bungalow->getCar_id(),
                "surface" => $bungalow->getSurface(),
                "id" => $bungalow->getId(),
            ];
            
            $query->execute($parameters);

            return $bungalow; 
    }
    
    // Supprimer un bungalow
    public function deleteBungalow(int $id): void
    {
        $query = $this->db->prepare("DELETE FROM bungalows WHERE id = :id");
        
            $parameters = [
                "id" => $id
                ];
                
            $query->execute($paramters);    
        
    }
    
    //Vérifier la disponibilités des bungalows
    public function checkAvailability(DateTime $startDate, DateTime $endDate, int $capacity): array {
        $query = $this->db->prepare("
            SELECT b.*
            FROM bungalows b
            WHERE b.capacity >= :capacity
            AND b.id NOT IN (
                SELECT r.bungalow_id
                FROM reservations r
                WHERE NOT (r.end_date < :startDate OR r.start_date > :endDate)
            )
        ");

        $parameters = [
            ':startDate' => $startDate->format('Y-m-d'),
            ':endDate' => $endDate->format('Y-m-d'),
            ':capacity' => $capacity
        ];
        $query->execute($parameters);
        // Utiliser fetchAll pour récupérer plusieurs bungalows
        $availables = $query->fetchAll(PDO::FETCH_ASSOC);

        $availableBungalows = [];
        foreach ($availables as $available)
        {
            $item = new Bungalow($available['name'], $available['description'], $available['capacity'], $available['price'], $available['car_id'], $available['surface']);
            $item->setId($available["id"]);
            $availableBungalows[] = $item;
        }
        
        return $availableBungalows;
    }
}