<?php

class ReservationManager extends AbstractManager
{
    public function __construct()
    {
        parent::__construct();
    }
    
    // Créer une réservation
    public function createReservation(Reservation $reservation) : int//Reservation
    {
        $query = $this->db->prepare('INSERT INTO reservation (id, user_id, bungalow_id, start_date, end_date, created_at, total_price) VALUES (NULL, :user_id, :bungalow_id, :start_date, :end_date, :created_at, :total_price)');
        $parameters = [
            "user_id" => $reservation->getUser()->getId(),
            "bungalow_id" => $reservation->getBungalow()->getId(),
            "start_date" => $reservation->getStartDate()->format('Y-m-d H:i:s'),
            "end_date" => $reservation->getEndDate()->format('Y-m-d H:i:s'),
            "created_at" => $reservation->getCreatedAt()->format('Y-m-d H:i:s'),
            "total_price" => $reservation->getTotalPrice(),
        ];

        // Exécution de la requête SQL
        $query->execute($parameters);
        
        // Récupérer l'ID du dernier reservation inséré
        $reservation->setId($this->db->lastInsertId());

        return  (int) $reservation;
    }

    // Récupérer toutes les réservations
    public function findAllReservations(): array
    {
        $reservations = [];

        $query = $this->db->prepare("SELECT r.*, u.id AS user_id, u.first_name, u.last_name, b.id AS bungalow_id, b.name
                FROM reservation r
                JOIN users u ON r.user_id = u.id
                JOIN bungalows b ON r.bungalow_id = b.id");
        
        $query->execute();

        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $item) {
            $user = new User($item['user_id'], $item['first_name'], $item['last_name']);
            $bungalow = new Bungalow($item['bungalow_id'], $item['name']);
            
            $reservation = new Reservation(
                $user,
                $bungalow,
                new DateTime($item["start_date"]),
                new DateTime($item["end_date"]),
                new DateTime($item["created_at"]),
                $item["total_price"]
            );
            $reservation->setId($item["id"]);

            $reservations[] = $reservation;
        }

        return $reservations;
    }
    
    public function isBungalowAvailable(int $bungalowId, string $startDate, string $endDate): bool
{
    // Préparer la requête SQL pour vérifier les chevauchements de dates
    $query = $this->db->prepare('
        SELECT COUNT(*) FROM reservation 
        WHERE bungalow_id = :bungalow_id 
        AND (start_date <= :end_date AND end_date >= :start_date)'
    );
    
    // Paramètres de la requête
    $parameters = [
        "bungalow_id" => $bungalowId,
        "start_date" => $startDate,
        "end_date" => $endDate,
    ];

    // Exécution de la requête
    $query->execute($parameters);

    // Récupérer le nombre de réservations qui chevauchent cette période
    $count = $query->fetchColumn();

    // Si le nombre est 0, le bungalow est disponible
    return $count == 0;
}

    // Récupérer une réservation par son ID
    public function findReservationById(int $id): ?Reservation
    {
        $query = $this->db->prepare("SELECT r.*, u.id AS user_id, u.first_name, u.last_name, b.id AS bungalow_id, b.name
                FROM reservation r
                JOIN users u ON r.user_id = u.id
                JOIN bungalows b ON r.bungalow_id = b.id
                WHERE r.id = :id");
                
        $query->execute(['id' => $id]);

        $item = $query->fetch(PDO::FETCH_ASSOC);

        if ($item) {
            $reservation = new Reservation(
                $user,
                $bungalow,
                new DateTime($item["start_date"]),
                new DateTime($item["end_date"]),
                new DateTime($item["created_at"]),
                $item["total_price"]
            );
            $reservation->setId($item["id"]);

            return $reservation;
        }

        return null;
    }
    
    // Mettre à jour une réservation
    public function updateReservation(Reservation $reservation): Reservation
    {
        $query = $this->db->prepare('
            UPDATE reservation 
            SET user_id = :user_id, bungalow_id = :bungalow_id, start_date = :start_date, 
            end_date = :end_date, created_at = :created_at, total_price = :total_price 
            WHERE id = :id'
        );
        $parameters = [
            "user_id" => $reservation->getUser()->getId(),
            "bungalow_id" => $reservation->getBungalow()->getId(),
            "start_date" => $reservation->getStartDate()->format('Y-m-d H:i:s'),
            "end_date" => $reservation->getEndDate()->format('Y-m-d H:i:s'),
            "created_at" => $reservation->getCreatedAt()->format('Y-m-d H:i:s'),
            "total_price" => $reservation->getTotalPrice(),
            "id" => $reservation->getId(),
        ];

        return $query->execute($parameters);
    }
    
    // Supprimer une réservation
    public function deleteReservation(int $id): bool
    {
        $query = $this->db->prepare("DELETE FROM reservation WHERE id = :id");
        return $query->execute(["id" => $id]);
    }

    // Vérifier la disponibilité d'un bungalow sur une période donnée
    /*public function isBungalowAvailable(int $bungalowId, string $startDate, string $endDate): bool
    {
        $query = $this->db->prepare('
            SELECT COUNT(*) FROM reservation 
            WHERE bungalow_id = :bungalow_id 
            AND (start_date <= :end_date AND end_date >= :start_date)'
        );
        $parameters = [
            "bungalow_id" => $bungalowId,
            "start_date" => $startDate,
            "end_date" => $endDate,
        ];

        $query->execute($parameters);
        $count = $query->fetchColumn();

        // Si le nombre est 0, cela signifie qu'il n'y a pas de réservation chevauchant cette période
        return $count == 0;
    }*/
}