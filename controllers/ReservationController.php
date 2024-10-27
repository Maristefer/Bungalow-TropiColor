<?php
//gére les action de recherche de disponibilité et de réservation
class ReservationController extends AbstractController
{
    
    private BungalowManager $bm;
    private ReservationManager $rm;
    private UserManager $um;
    
    public function __construct() {
        parent::__construct();
        $this->bm = new BungalowManager();
        $this->rm = new ReservationManager();
        $this->um = new UserManager();
    }
    
    Public function confirmation()
    {
         $this->render('front/bungalows/confirmation.html.twig', []);
    }
    
    public function createReserve()
    {
        // Vérifier que les paramètres GET sont présents
        if (!isset($_GET['bungalow_id'], $_GET['start_date'], $_GET['end_date'])) {
            echo "Paramètres manquants pour la réservation.";
            return;
        }
    
    // Vérifier que l'utilisateur est connecté
     if (!isset($_SESSION['user_id'])|| !is_int($_SESSION['user_id'])) {
        echo "Vous devez être connecté pour effectuer une réservation.";
        return;
    }
    
    
        // Récupérer les paramètres GET de l'URL
        $bungalowId = (int)$_GET['bungalow_id'];
        $startDate = htmlspecialchars($_GET['start_date']);
        $endDate = htmlspecialchars($_GET['end_date']);
        $userId = $_SESSION['user_id']; // Identifiant de l'utilisateur connecté
        
        // Vérifier et formater les dates
        $startDateObj = DateTime::createFromFormat('Y-m-d', $startDate);
        $endDateObj = DateTime::createFromFormat('Y-m-d', $endDate);
    
        if (!$startDateObj || !$endDateObj || $startDateObj > $endDateObj) {
            echo "Les dates de réservation sont invalides.";
            return;
        }
        
        // Récupérer l'objet User correspondant à l'utilisateur connecté
        $um = new UserManager(); // Il faudra implémenter cette classe
        $user = $um->findUserById($userId);
        
        if (!$user) {
            echo "Utilisateur introuvable.";
            return;
        }
        
        // Vérifier la disponibilité du bungalow pour les dates sélectionnées
        if (!$this->rm->isBungalowAvailable($bungalowId, $startDate, $endDate)) {
            // Gérer le cas où le bungalow n'est pas disponible
            echo "Le bungalow sélectionné n'est pas disponible pour ces dates.";
            return;
        }
        
        // Récupérer l'objet Bungalow pour obtenir les informations du bungalow
        $bungalow = $this->bm->findBungalowById($bungalowId);
        
        if (!$bungalow) {
            echo "Bungalow introuvable.";
            return;
        }

        //calcul le nbre de nuits
        $nbNights = $startDateObj->diff($endDateObj)->days;
        
        if ($nbNights <= 0) {
            echo "Les dates de réservation sont invalides.";
            return;
        }
        // Calculer le prix total en fonction de la durée de séjour
        $totalPrice = $bungalow->getPrice() * $nbNights;

        // Créer une nouvelle réservation
        $reservation = new Reservation($user, $bungalow, $startDateObj, $endDateObj, new DateTime(), $totalPrice);
        
        // Enregistrer la réservation dans la base de données
        //$this->rm->createReservation($reservation);
        $reservationId = $this->rm->createReservation($reservation);
        // Rediriger vers la page de confirmation
        //$this->redirect("confirmation");
        $this->redirect("index.php?route=show-confirmation?reservation_id=$reservationId");
        
    }
    
    public function showConfirmation(int $reservationId) :void
    {
        // Récupérer l'ID de la réservation à partir de la requête GET
        $reservationId = $_GET['reservation_id'] ?? null;
    
        if ($reservationId) {
            // Trouver la réservation avec l'ID
            $reservation = $this->rm->findReservationById((int)$reservationId);
            if ($reservationId) {
                // Rendre le template de confirmation avec la réservation
                $this->render('front/bungalows/confirmation.html.twig', ['reservation' => $reservation]);
            }
            else
            {
                echo "Réservation introuvable.";
            }
        }
        else
        {
            echo "Aucune réservation spécifiée.";
        }
    }
    
}