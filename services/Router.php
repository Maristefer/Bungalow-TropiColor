<?php

class Router 
{
    private DiscoveryController $dc;
    private BungalowController $bc;
    private DefaultController $dfc;
    private AuthController $ac;
    private AdminController $adc;
    private UserController $uc;
    
    
    public function __construct()
    {
        $this->dc = new DiscoveryController();
        $this->bc = new BungalowController();
        $this->dfc = new DefaultController();
        $this->ac = new AuthController();
        $this->adc = new AdminController();
        $this->uc = new UserController();
    }
    
    public function handleRequest(array $get): void
    {
        if(!isset($get["route"]))
        {
            $this->dfc->homepage();
        }
        else if(isset($get["route"]) && $get["route"] === "home")
        {
             $this->dfc->homepage(); 
        }
        else if(isset($get["route"]) && $get["route"] === "discovery")
        {
            $this->dc->discovery();
        }
        else if(isset($get["route"]) && $get["route"] === "discovery_beach")
        {
            $this->dc->listePlages();
        }
        else if(isset($get["route"]) && $get["route"] === "discovery_rivers")
        {
            $this->dc->listeRivers();
        }
        else if(isset($get["route"]) && $get["route"] === "discovery_restaurants")
        {
            $this->dc->listeRestaurants();
        }
        else if(isset($get["route"]) && $get["route"] === "discovery_hikes")
        {
            $this->dc->listeHikes();
        }
         else if(isset($get["route"]) && $get["route"] === "discovery_parks")
        {
            $this->dc->listeParks();
        }
        else if(isset($get["route"]) && $get["route"] === "discovery_visits")
        {
            $this->dc->listeVisits();
        }
        else if(isset($get["route"]) && $get["route"] === "bungalows")
        {
            $this->bc->listeBungalows();
        }
        else if(isset($get["route"]) && $get["route"] === "recherche-bungalows")
        {
            $this->bc->displayBungalows();
        }
        else if(isset($get["route"]) && $get["route"] === "reservation")
        {
            $this->bc->availability();
        }
        else if(isset($get["route"]) && $get["route"] === "check-disponibilite")
        {
            $this->bc->searchAvailability();
        }
         else if(isset($get["route"]) && $get["route"] === "inscription")
        {
            $this->ac->register();
        }
         else if(isset($get["route"]) && $get["route"] === "check-inscription")
        {
            $this->ac->checkRegister();
        }
         else if(isset($get["route"]) && $get["route"] === "connexion")
        {
            $this->ac->login();
        }
         else if(isset($get["route"]) && $get["route"] === "check-connexion")
        {
            $this->ac->checkLogin();
        }
        else if(isset($get["route"]) && $get["route"] === "deconnexion")
        {
            $this->ac->logout();
        }
        else if(isset($get["route"]) && $get["route"] === "admin")
        {
            $this->checkAdminAccess();
            $this->adc->home();
        }
         else if(isset($get["route"]) && $get["route"] === "admin-connexion")
        {
            $this->adc->login();
        }
        else if(isset($get["route"]) && $get["route"] === "admin-check-connexion")
        {
            $this->adc->checkLogin();
        }
        else if(isset($get["route"]) && $get["route"] === "admin-deconnexion")
        {
            $this->adc->logout();
        }
        else if(isset($get["route"]) && $get["route"] === "admin-create-user")
        {
            $this->checkAdminAccess();
            $this->uc->create();
        }
         else if(isset($get["route"]) && $get["route"] === "admin-check-create-user")
        {
            $this->checkAdminAccess();
            $this->uc->checkCreate();
        }
        else if(isset($get["route"]) && $get["route"] === "admin-edit-user")
        {
            $this->checkAdminAccess();
            
            if (isset($_GET['user_id'])) {
                $userId = (int)$_GET['user_id'];
                $this->uc->edit($userId);
            } else {
                $this->redirect("admin-list-user");
            }
        }
         else if(isset($get["route"]) && $get["route"] === "admin-check-edit-user")
        {
           $this->checkAdminAccess();
            $this->uc->checkEdit();
        }
        else if(isset($get["route"]) && $get["route"] === "admin-delete-user")
        {
           $this->checkAdminAccess();
            //vérifie si le paramètre $_GET['user_id'] existe.
            if(isset($_GET['user_id']))
            {
                //Si le paramètre existe, il est transformé en entier en utilisant le casting (int).
                $userId = (int)$_GET['user_id'];
                //Méthode show du UserController est appelée avec l'ID de l'utilisateur transformé en entier.
                $this->uc->delete($userId);
            }
            else
            {
                $this->redirect("admin-list-user");
            }
        }
        else if(isset($get["route"]) && $get["route"] === "admin-list-user")
        {
           $this->checkAdminAccess();
            $this->uc->list();
        }
        else if(isset($get["route"]) && $get["route"] === "admin-show-user")
        {
           $this->checkAdminAccess();
            //vérifie si le paramètre $_GET['user_id'] existe.
            if(isset($_GET['user_id']))
            {
                //Si le paramètre existe, il est transformé en entier en utilisant le casting (int).
                $userId = (int)$_GET['user_id'];
                //Méthode show du UserController est appelée avec l'ID de l'utilisateur transformé en entier.
                $this->uc->show($userId);
            }
            else
            {
                $this->redirect("admin-list-user");
            }
        }
        else
        {
            // le code si c'est aucun des cas précédents ( === page 404)
            $this->dfc->notFound();
        }
        
    }
    
    private function checkAdminAccess(): void
    {
        if(isset($_SESSION['user']) 
            && isset($_SESSION['role']) && $_SESSION['role'] === "ADMIN")
            {
                // c'est bon
                //$this->adc->home();
            }
            else
            {
                     // c'est pas bon : redirection avec un header('Location:')
                     $this->redirect("admin-connexion");
            }
    }
    
    protected function redirect(? string $route) : void 
    {
        if($route !== null)
        {
            header("Location: index.php?route=$route");
        }
        else
        {
            header("Location: index.php");
        }
        exit();
    }   
}