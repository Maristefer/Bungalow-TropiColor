<?php
//gére les action de recherche de disponibilité et de réservation
class ReservationController extends AbstractController
{
    
    private BungalowManager $bm;
    private ReservationManager $rm;
    
    public function __construct() {
        parent::__construct();
        $this->bm = new BungalowManager();
        $this->rm = new ReservationManager();
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
    
        // Récupérer les paramètres GET de l'URL
        $bungalowId = $_GET['bungalow_id'];
        $startDate = $_GET['start_date'];
        $endDate = $_GET['end_date'];
        $userId = $_SESSION['user_id']; // Identifiant de l'utilisateur connecté
        
        // Vérifier la disponibilité du bungalow pour les dates sélectionnées
        if (!$this->rm->isBungalowAvailable($bungalowId, $startDate, $endDate)) {
            // Gérer le cas où le bungalow n'est pas disponible
            echo "Le bungalow sélectionné n'est pas disponible pour ces dates.";
            return;
        }

        // Calculer le prix total en fonction de la durée de séjour
        $bungalow = $this->bm->findBungalowById($bungalowId);
        $nbNights = (strtotime($endDate) - strtotime($startDate)) / 86400;
        $totalPrice = $bungalow->getPrice() * $nbNights;

        // Créer une nouvelle réservation
        $reservation = new Reservation($userId, $bungalowId, $startDate, $endDate, date('Y-m-d H:i:s'), $totalPrice);
        
        $this->rm->createReservation($reservation);
        
        $this->redirect("confirmation");
        
        // Rediriger ou afficher un message de succès
        //echo "Réservation réussie!";
        // Ou rediriger vers une page de confirmation
        // header('Location: /reservation/confirmation');
    }
    
}