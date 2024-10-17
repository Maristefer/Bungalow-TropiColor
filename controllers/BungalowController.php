<?php

class BungalowController extends AbstractController
{
    
    private BungalowManager $bm;
    
    public function __construct() {
        parent::__construct();
        $this->bm = new BungalowManager();
    }
    
    // Affiche le formulaire de recherche de disponibilité
    public function availability(): void {
        $this->render('front/bungalows/availability.html.twig', []);
    }
    
    
    public function listeBungalows(): void
    {
        $bm = new BungalowsManager();
        
        $bungalows = $bm->findAllBungalows();
        
        $this->render("bungalows/bungalows.html.twig",[
            "bungalows" =>$bungalows
            ]);
    }
    
   /* public function displayBungalow(int $id)
    {
        $bungalow = $this->bm->findBungalowById($id);
        
        if ($bungalow) {
            include 'bungalow_view.php';
        } else {
            echo "Bungalow non trouvé";
        }
    }*/
    
    /*public function search() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $startDate = $_POST['startDate'];
        $endDate = $_POST['endDate'];
        $capacity = $_POST['capacity'];

        // Validation des dates côté serveur
        if (strtotime($endDate) <= strtotime($startDate)) {
            echo $this->twig->render('search.twig', ['error' => 'La date de fin doit être postérieure à la date de début.']);
            return;
        }

        // Si les dates sont valides, rechercher les bungalows
        $bungalows = $this->model->getAvailableBungalows($startDate, $endDate, $capacity);
        echo $this->twig->render('search_results.twig', ['bungalows' => $bungalows, 'startDate' => $startDate, 'endDate' => $endDate]);
    } else {
        echo $this->twig->render('search.twig');
    }
}*/
    
}
    
