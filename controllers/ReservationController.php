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
     if (isset($_SESSION['user_id'])) {
    echo "Vous êtes connecté, utilisateur ID : " . $_SESSION['user_id'];
    } else {
    echo "Vous n'êtes pas connecté.";
    }
    
    
        // Récupérer les paramètres GET de l'URL
        $bungalowId = $_GET['bungalow_id'];
        $startDate = $_GET['start_date'];
        $endDate = $_GET['end_date'];
        $userId = $_SESSION['user_id']; // Identifiant de l'utilisateur connecté
        
        // Récupérer l'objet User correspondant à l'utilisateur connecté
        $um = new UserManager(); // Il faudra implémenter cette classe
        $user = $um->findUserById($useId);
        
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
        $nbNights = (strtotime($endDate) - strtotime($startDate)) / 86400;
        
        if ($nbNights <= 0) {
            echo "Les dates de réservation sont invalides.";
            return;
        }
        // Calculer le prix total en fonction de la durée de séjour
        $totalPrice = $bungalow->getPrice() * $nbNights;

        // Créer une nouvelle réservation
        $reservation = new Reservation($user, $bungalow, new DateTime($startDate), new DateTime($endDate), new DateTime(), $totalPrice);
        
        // Enregistrer la réservation dans la base de données
        $this->rm->createReservation($reservation);
        
        // Rediriger vers la page de confirmation
        $this->redirect("confirmation");
        
    }
    
}