<?php

class AuthController extends AbstractController {

    private UserManager $um;
    
    public function __construct() {
        parent::__construct();
        $this->um = new UserManager();
    }
    
    public function register() : void
    {
        $this->render('front/auth/register.html.twig', []);
    }
    
    /*$password = password_hash("test", PASSWORD_BCRYPT);
    $user = new User("test@test.fr", $password, "USER");
    $this->um->createUser($user);*/
    public function checkRegister() : void
    {
        // Debug pour voir les données reçues dans le formulaire
    var_dump($_POST);
        //vérifie que tous les champs du formulaire (email, password, confirm_password,ect) sont bien présents. 
        //Si ce n'est pas le cas elle redirige vers la page d'inscription et affiche un message d'erreur.
        if(isset($_POST["last_name"]) && isset($_POST["first_name"]) && isset($_POST["date_of_birth"]) 
        && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["confirm_password"])
        && isset($_POST["number"]) && isset($_POST["street"]) && isset($_POST["postale_code"])
        && isset($_POST["city"]) && isset($_POST["phone"]))
        {
            $tokenManager = new CSRFTokenManager();
            
            //Vérifie si le csrf_token est présent et utilise le CSRFTokenManager pour vérifier que le token reçu est le bon, 
            //si ça n'est pas le cas elle redirige vers la page d'inscription et affiche un message d'erreur.
            if(isset($_POST["csrf_token"]) && $tokenManager->validateCSRFToken($_POST["csrf_token"]))
            {
                // Vérification de la validité des champs
                 if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
                    $_SESSION["error_message"] = "Invalid email format";
                    $this->redirect("inscription");
                    return;
                }
                    // Vérification des mots de passe
                    if($_POST["password"] === $_POST["confirm_password"])
                    {
                        // Mot de passe doit respecter les règles de sécurité
                        $password_pattern = "/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/";

                        if (preg_match($password_pattern, $_POST["password"]))
                        {
                            $um = new UserManager();
                            $user = $um->findUserByEmail($_POST["email"]);

                            if($user === null)
                            {
                                // Créer une nouvelle adresse
                            $address = new Address(
                                htmlspecialchars($_POST["number"]),
                                htmlspecialchars($_POST["street"]),
                                htmlspecialchars($_POST["complement"] ?? ""), // facultatif
                                htmlspecialchars($_POST["postale_code"]),
                                htmlspecialchars($_POST["city"])
                            );
                                
                                // Créer un nouvel utilisateur si l'email n'existe pas encore
                                $lastname = htmlspecialchars($_POST["last_name"]);
                                $firstname = htmlspecialchars($_POST["first_name"]);
                                $date_of_birth_raw = htmlspecialchars($_POST["date_of_birth"]);
                            
                                // Vérification et conversion de la date de naissance au format 'Y-m-d'
                                $date_of_birth = DateTime::createFromFormat('Y-m-d', $date_of_birth_raw);

                                if (!$date_of_birth || $date_of_birth->format('Y-m-d') !== $date_of_birth_raw) {
                                    $_SESSION["error_message"] = "Invalid date of birth format. Please use YYYY-MM-DD.";
                                    $this->redirect("inscription");
                                    return;
                                }
                                
                                // Convertir la date au format 'Y-m-d H:i:s' pour la base de données
                                $date_of_birth_formatted = $date_of_birth->format('Y-m-d H:i:s');
                            
                                $email = htmlspecialchars($_POST["email"]);
                                $password = password_hash($_POST["password"], PASSWORD_BCRYPT);
                                $phone = htmlspecialchars($_POST["phone"]);
                            
                                // Créer l'instance de l'utilisateur avec tous les champs
                                $user = new User($lastname, $firstname, $date_of_birth, $email, $password, $address, $phone, 'USER');

                                $um->createUser($user);// Ajoute l'utilisateur à la base de données

                                $_SESSION["user"] = $user->getId();// Sauvegarde l'utilisateur dans la session

                                unset($_SESSION["error_message"]);

                                $this->redirect("connexion");
                        }
                        else
                        {
                            $_SESSION["error_message"] = "User already exists";
                            $this->redirect("inscription");
                        }
                    }
                    else {
                        $_SESSION["error_message"] = "Password is not strong enough";
                        $this->redirect("inscription");
                    }
                }
                else
                {
                    $_SESSION["error_message"] = "The passwords do not match";
                    $this->redirect("inscription");
                }
            }
            else
            {
                $_SESSION["error_message"] = "Invalid CSRF token";
                $this->redirect("inscription");
            }
        }
        else
        {
            $_SESSION["error_message"] = "Missing fields";
            $this->redirect("inscription");
        }
        
        
    }
    
    public function login() : void
    {
        $this->render('front/auth/login.html.twig', []);
    }
    
   //méthode qui doit vérifier ce qui a été envoyé par le formulaire de connexion et connecter l'utilisateur dans la session si les informations sont correctes.
     /*$user = $this->um->findUserByEmail("test@test.fr");
        dump($user);*/
    public function checkLogin() : void 
    {
       
         if(isset($_POST["email"]) && isset($_POST["password"]))
        {
            $tokenManager = new CSRFTokenManager();

            if(isset($_POST["csrf_token"]) && $tokenManager->validateCSRFToken($_POST["csrf_token"]))
            {
                $um = new UserManager();
                $user = $um->findUserByEmail($_POST["email"]);

                if($user !== null)
                {
                    if(password_verify($_POST["password"], $user->getPassword()))
                    {
                        $_SESSION["user"] = $user->getId();
                        $_SESSION["role"] = $user->getRole();

                        unset($_SESSION["error_message"]);

                        $this->redirect("index.php");
                    }
                    else
                    {
                        $_SESSION["error_message"] = "Invalid login information";
                        $this->redirect("connexion");
                    }
                }
                else
                {
                    $_SESSION["error_message"] = "Invalid login information";
                    $this->redirect("connexion");
                }
            }
            else
            {
                $_SESSION["error_message"] = "Invalid CSRF token";
                $this->redirect("connexion");
            }
        }
        else
        {
            $_SESSION["error_message"] = "Missing fields";
            $this->redirect("connexion");
        }
    }
    
    public function logout() : void
    {
        session_destroy();
        
        $this->redirect("index.php");
    }
}