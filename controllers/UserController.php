<?php

class UserController extends AbstractController
{
    private UserManager $um;
    
    public function __construct(){
        parent::__construct();
        $this->um = new UserManager();
    }

    public function create() : void 
    {
        $this->render("admin/users/create.html.twig", []);
    }

    public function checkCreate() : void 
    {
        //vérifie que tous les champs du formulaire (email, password, confirm_password) sont bien présents. 
        //Si ce n'est pas le cas elle redirige vers la page d'inscription et affiche un message d'erreur.
        if(isset($_POST["last_name"]) && isset($_POST["first_name"]) && isset($_POST["date_of_birth"]) 
        && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["confirm_password"]) 
        && isset($_POST["number"]) && isset($_POST["street"]) && isset($_POST["postale_code"])
        && isset($_POST["city"]) && isset($_POST["phone"]) && isset($_POST["role"]))
        {
            $tokenManager = new CSRFTokenManager();
            
            //Vérifie si le csrf_token est présent et utilise le CSRFTokenManager pour vérifier que le token reçu est le bon, 
            //si ça n'est pas le cas elle redirige vers la page d'inscription et affiche un message d'erreur.
            if(isset($_POST["csrf_token"]) && $tokenManager->validateCSRFToken($_POST["csrf_token"]))
            {
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
                            $role = htmlspecialchars($_POST["role"]);
                            $phone = htmlspecialchars($_POST["phone"]);
                            $created_at = new DateTime('now', new DateTimeZone('Europe/Paris'));
                            $user = new User($lastname, $firstname, $date_of_birth, $email, $password, $address, $phone, $created_at, $role);

                            $um->createUser($user);// Ajoute l'utilisateur à la base de données

                            $_SESSION["user"] = $user->getId();// Sauvegarde l'utilisateur dans la session

                            unset($_SESSION["error_message"]);

                            $this->redirect("admin-list-user");
                        }
                        else
                        {
                            $_SESSION["error_message"] = "User already exists";
                            $this->redirect("admin-create-user");
                        }
                    }
                    else {
                        $_SESSION["error_message"] = "Password is not strong enough";
                        $this->redirect("admin-create-user");
                    }
                }
                else
                {
                    $_SESSION["error_message"] = "The passwords do not match";
                    $this->redirect("admin-create-user");
                }
            }
            else
            {
                $_SESSION["error_message"] = "Invalid CSRF token";
                $this->redirect("admin-create-user");
            }
        }
        else
        {
            $_SESSION["error_message"] = "Missing fields";
            $this->redirect("admin-create-user");
        }
        
    }

    public function edit(int $id) : void 
    {
        $user = $this->um->findUserById($id);
        
        if($user !== null)
        {
             $this->render("admin/users/edit.html.twig", ['user' => $user]);
        }
        else
        {
            $this->redirect("admin-list-user");
        }
    }

    public function checkEdit() : void 
    {
        if(isset($_POST["last_name"]) && isset($_POST["first_name"]) && isset($_POST["date_of_birth"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["confirm_password"]) 
        && isset($_POST["number"]) && isset($_POST["street"]) && isset($_POST["postale_code"]) && isset($_POST["city"]) && isset($_POST["phone"])&& isset($_POST["role"])
        && isset($_POST["user_id"]) && isset($_POST["address_id"]))
        {
            $tokenManager = new CSRFTokenManager();
            
            //Vérifie si le csrf_token est présent et utilise le CSRFTokenManager pour vérifier que le token reçu est le bon, 
            //si ça n'est pas le cas elle redirige vers la page d'inscription et affiche un message d'erreur.
            if(isset($_POST["csrf_token"]) && $tokenManager->validateCSRFToken($_POST["csrf_token"]))
            {
                if($_POST["password"] === $_POST["confirm_password"])
                {
                    // Mot de passe doit respecter les règles de sécurité
                    $password_pattern = "/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/";

                    if (preg_match($password_pattern, $_POST["password"]))
                    {
                        $um = new UserManager();
                        /*$user = $um->findUserByEmail($_POST["email"]);

                        if($user === null)
                        {*/
                            $addressId = (int)$_POST["address_id"];
                            $number = (int)$_POST["number"];
                            
                            $address = new Address(
                                
                                $number,
                                htmlspecialchars($_POST["street"]),
                                htmlspecialchars($_POST["complement"] ?? ""), // facultatif
                                htmlspecialchars($_POST["postale_code"]),
                                htmlspecialchars($_POST["city"]),
                                $addressId,
                            );
                            
                            $userId = (int)$_POST["user_id"];
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
                            $created_at = new DateTime('now', new DateTimeZone('Europe/Paris'));
                            $role = htmlspecialchars($_POST["role"]);
                            
                            $user = new User($lastname, $firstname, $date_of_birth, $email, $password, $address, $phone, $created_at, $role);
                            $user->setId($userId);
                            $user->setAddress($address);

                            $um->updateUser($user);/// Met à jour l'utilisateur dans la base de données


                            $_SESSION["user"] = $user->getId();// Sauvegarde l'utilisateur dans la session

                            unset($_SESSION["error_message"]);

                            $this->redirect("admin-list-user");
                        /*}
                        else
                        {
                            $_SESSION["error_message"] = "User already exists";
                            $this->redirect("admin-edit-user&user_id=$userId");
                        }*/
                    }
                    else {
                        $_SESSION["error_message"] = "Password is not strong enough";
                        $this->redirect("admin-edit-user&user_id=$userId");
                    }
                }
                else
                {
                    $_SESSION["error_message"] = "The passwords do not match";
                    $this->redirect("admin-edit-user&user_id=$userId");
                }
            }
            else
            {
                $_SESSION["error_message"] = "Invalid CSRF token";
                $this->redirect("admin-edit-user&user_id=$userId");
            }
        }
        else
        {
            $_SESSION["error_message"] = "Missing fields";
            $this->redirect("admin-edit-user&user_id=$userId");
        }
    }

    public function delete(int $id) : void 
    {
        $this->um->deleteUser($id);
        $this->redirect("admin-list-user");
    }

    public function list() : void 
    {
        $users = $this->um->findAllUsers();
        $this->render("admin/users/list.html.twig", ['users' => $users]);
    }

    public function show(int $id) : void {
        
        $user = $this->um->findUserById($id);
        
        if($user !== null)
        {
             $this->render("admin/users/show.html.twig", ['user' => $user]);
        }
        else
        {
            $this->redirect("admin-list-user");
        }
    }
}