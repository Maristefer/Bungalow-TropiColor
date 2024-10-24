<?php
//gére les action de recherche de disponibilité et de réservation
class BungalowController extends AbstractController
{
    
    private BungalowManager $bm;
    private ReservationManager $rm;
    
    public function __construct() {
        parent::__construct();
        $this->bm = new BungalowManager();
        $this->rm = new ReservationManager();
    }
    
    // Affiche le formulaire de recherche de disponibilité
    public function availability(): void {
        $this->render('front/bungalows/availability.html.twig', []);
    }
    
    // Recherche les bungalows disponibles
    public function searchAvailability(): void {
        if (isset($_POST['start_date'], $_POST['end_date'], $_POST['capacity'])) {
            $startDate = DateTime::createFromFormat('Y-m-d', $_POST['start_date']);
            $endDate = DateTime::createFromFormat('Y-m-d', $_POST['end_date']);
            $capacity = (int)$_POST['capacity'];

            if ($startDate && $endDate && $capacity > 0 && $startDate < $endDate) {
                $availableBungalows = $this->bm->checkAvailability($startDate, $endDate, $capacity);
                $startDateFormated = $startDate->format('Y-m-d');
                $endDateFormated = $endDate->format('Y-m-d');
                $this->render('front/bungalows/availability.html.twig', ['bungalows' => $availableBungalows, 'startDate' => $startDateFormated, 'endDate' => $endDateFormated]);
            } else {
                $_SESSION['error_message'] = 'Invalid search parameters.';
                $this->redirect('reservation');
            }
        } else {
            $_SESSION['error_message'] = 'Please provide all required fields.';
            $this->redirect('reservation');
        }
    }
    
    // Réservation d'un bungalow
    /*public function reserve(int $bungalowId): void {
        if (isset($_POST['user_id'], $_POST['start_date'], $_POST['end_date'], $_POST['total_price'])) {
            $userId = (int)$_POST['user_id'];
            $startDate = DateTime::createFromFormat('Y-m-d', $_POST['start_date']);
            $endDate = DateTime::createFromFormat('Y-m-d', $_POST['end_date']);
            $totalPrice = (int)$_POST['total_price'];

            $reservation = new Reservation(0, $bungalowId, $userId, $startDate, $endDate, $totalPrice);
            $this->rm->createReservation($reservation);

            $_SESSION['success_message'] = 'Reservation successfully created!';
            $this->redirect('availability');
        } else {
            $_SESSION['error_message'] = 'Please fill in all fields.';
            $this->redirect('reserve/'.$bungalowId);
        }
    }*/
    
    // Afficher tous les bungalows
    public function listeBungalows(): void
    {
        $bm = new BungalowsManager();
        
        $bungalows = $bm->findAllBungalows();
        
        $this->render("front/bungalows/bungalows.html.twig",[
            "bungalows" =>$bungalows
            ]);
    }
    
    // Afficher tous les bungalows page réservation
    public function displayBungalows(): void
    {
        $bm = new BungalowManager();
        
        $bungalows = $bm->findAllBungalows();
        
        $this->render("front/bungalows/search.html.twig",[
            "bungalows" =>$bungalows
            ]);
    }
    
    // Afficher tous les bungalows page home
    public function displayBungalowsHome(): void
    {
        $bm = new BungalowManager();
        
        $bungalows = $bm->findAllBungalows();
        
        $this->render("front/home.html.twig",[
            "bungalows" =>$bungalows
            ]);
    }
    // Afficher un bungalow spécifique
    public function show(int $id) : void
    {
        $bungalow = $this->bm->findBungalowById($id);
        if ($bungalow) {
            require 'views/bungalows/show.php'; // Vue pour afficher un bungalow spécifique
        } else {
            // Gérer l'erreur si le bungalow n'existe pas
            $this->redirect("admin-list-bungalow");
            echo 'Bungalow not found';
        }
    }

    // Créer un nouveau bungalow
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $bungalow = new Bungalow(
                $_POST['name'],
                $_POST['description'],
                $_POST['photo_id'],
                $_POST['capacity'],
                $_POST['price'],
                $_POST['car_id'],
                $_POST['surface']
            );

            $newBungalow = $this->bm->createBungalow($bungalow);
            header('Location: /bungalows/' . $newBungalow->getId()); // Rediriger vers le bungalow créé
        } else {
            require 'views/bungalows/create.php'; // Vue pour le formulaire de création
        }
    }

    // Mettre à jour un bungalow existant
    public function edit(int $id)
    {
        $bungalow = $this->bungalowManager->findBungalowById($id);

        if ($bungalow) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $bungalow->setName($_POST['name']);
                $bungalow->setDescription($_POST['description']);
                $bungalow->setPhoto_id($_POST['photo_id']);
                $bungalow->setCapacity($_POST['capacity']);
                $bungalow->setPrice($_POST['price']);
                $bungalow->setCar_id($_POST['car_id']);
                $bungalow->setSurface($_POST['surface']);

                $this->bungalowManager->updateBungalow($bungalow);
                header('Location: /bungalows/' . $bungalow->getId()); // Rediriger après la mise à jour
            } else {
                require 'views/bungalows/edit.php'; // Vue pour le formulaire d'édition
            }
        } else {
            header('HTTP/1.0 404 Not Found');
            echo 'Bungalow not found';
        }
    }

    // Supprimer un bungalow
    public function delete(int $id)
    {
        $this->bungalowManager->deleteBungalow($id);
        header('Location: /bungalows'); // Rediriger vers la liste des bungalows
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
    
}
    
