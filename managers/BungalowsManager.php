<?php

class BungalowsManager extends AbstractManager
{
    public function __construct()
    {
        parent::__construct();
    }

    public function findAllBungalows(): array
    {
        $bungalows = [];

        $query = $this->db->prepare("SELECT * FROM bungalows");
        $query->execute();

        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $item) {
            $bungalow = new Bungalows(
                $item["name"],
                $item["description"],
                $item["photo_id"],
                $item["capacity"],
                $item["price"],
                $item["care_id"],
                $item["surface"]
            );
            $bungalow->setId($item["id"]);

            $bungalows[] = $bungalow;
        }

        return $bungalows;
    }

    /*public function findBungalowById(int $id): ?Bungalows
    {
        $query = $this->db->prepare("SELECT * FROM bungalows WHERE id = :id");
        $query->execute(['id' => $id]);

        $item = $query->fetch(PDO::FETCH_ASSOC);

        if ($item) {
            $bungalow = new Bungalows(
                $item["name"],
                $item["description"],
                $item["photo_id"],
                $item["capacite"],
                $item["prix"],
                $item["vehicule_id"],
                $item["surface"]
            );
            $bungalow->setId($item["id"]);

            return $bungalow;
        }

        return null;
    }*/
}