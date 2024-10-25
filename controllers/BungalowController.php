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
    
    public function create() : void 
    {
        $this->render("admin/bungalows/create.html.twig", []);
    }

    // Créer un nouveau bungalow
    public function Checkcreate() : void
    {
        if (isset($_POST["name"], $_POST["description"], $_POST["photo_id"], $_POST["capacity"], $_POST["price"], $_POST["car_id"], $_POST["surface"])) 
        {
            // Assainissement des entrées utilisateur
            $name = htmlspecialchars($_POST["name"]);
            $description = htmlspecialchars($_POST["description"]);
            $photo_id = htmlspecialchars($_POST["photo_id"] ?? "");
            $capacity = (int) htmlspecialchars($_POST["capacity"]);
            $price = (int) htmlspecialchars($_POST["price"]);
            $car_id = htmlspecialchars($_POST["car_id"] ?? "");
            $surface = (int) htmlspecialchars($_POST["surface"]);

            // Crée une instance de bungalow avec les données fournies
            $bungalow = new Bungalow($name, $description, $photo_id, $capacity, $price, $car_id, $surface);

            // Sauvegarde du nouveau bungalow en utilisant le modèle
            $newBungalow = $this->bm->createBungalow($bungalow);
        
            // Redirige vers la page du nouveau bungalow créé
            $this->redirect("admin-list-bungalow/" . $newBungalow->getId());
        } 
        else 
        {
            // Si les champs ne sont pas complets, affiche de nouveau le formulaire avec un message d'erreur
            $_SESSION['error_message'] = 'Veuillez remplir tous les champs requis.';
            $this->render("admin/bungalows/create.html.twig", []);
    }
}

    // Mettre à jour un bungalow existant
    public function edit(int $id)
    {
        $bungalow = $this->bungalowManager->findBungalowById($id);

        if ($bungalow !== null) {
               $this->render("admin/bungalows/edit.html.twig", ['bungalow' => $bungalow]);
        }
        else
        {
            $this->redirect("admin-list-bungalow");
        }
    }
    
    public function checkEdit() : void
    {
        if(isset($_POST["name"], $_POST["description"], $_POST["photo_id"], $_POST["capacity"], $_POST["price"], $_POST["car_id"], $_POST["surface"], $_POST["bungalow_id"]))
        {
            $bungalow_id = (int)$_POST["bungalow_id"];
        
            $bungalow = $this->bm->findBungalowById($id);

            if ($bungalow !== null) {
               
                $bungalow->setName(htmlspecialchars($_POST["name"]));
                $bungalow->setDescription(htmlspecialchars($_POST["description"]));
                $bungalow->setPhoto_id(htmlspecialchars($_POST["photo_id"]));
                $bungalow->setCapacity((int)$_POST["capacity"]);
                $bungalow->setPrice((int)$_POST["price"]);
                $bungalow->setCar_id(htmlspecialchars($_POST["car_id"]));
                $bungalow->setSurface((int)$_POST["surface"]);

                $this->bm->updateBungalow($bungalow);
                
                $this->redirect('admin-list-bungalow');
            } 
            else 
            {
               $_SESSION['error_message'] = 'Bungalow not found';
                $this->redirect("admin-edit-bungalow?id=" . $id);
            }
        } 
        else 
        {
            $_SESSION['error_message'] = 'Please provide all required fields.';
            $this->redirect("admin-edit-bungalow?id=" . ($_POST["id"] ?? ""));
        }
    }

    // Supprimer un bungalow
    public function delete(int $id) : void
    {
        $this->bm->deleteBungalow($id);
        
        $_SESSION['success_message'] = 'Bungalow successfully deleted.';
        
        $this->redirect("admin-list-bungalow");
    }
    
    public function list() : void 
    {
        $bungalows = $this->um->findAllBungalows();
        
        $this->render("admin/bungalows/list.html.twig", ['bungalows' => $bungalows]);
    }

     // Afficher un bungalow spécifique
    public function show(int $id) : void {
        
        $bungalow = $this->bm->findBungalowById($id);
        
        if($bungalow !== null)
        {
             $this->render("admin/bungalows/show.html.twig", ['bungalow' => $bungalow]);
        }
        else
        {
            $this->redirect("admin-list-bungalow");
        }
    }
    
    
}
    
