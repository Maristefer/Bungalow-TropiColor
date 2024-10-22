<?php

class UserManager extends AbstractManager {

    public function __construct() {
        // J'appelle le constructeur de l'AbstractManager pour qu'il initialise la connexion à la DB
        parent::__construct();
    }
    
    //méthode qui permet d'entrer un nouvel utilisateur dans la base de données.
    //classe User en paramètre
    public function createUser(User $user) : User
    {
        $query = $this->db->prepare('INSERT INTO address (number, street, complement, postale_code, city) VALUES (:number, :street, :complement, :postale_code, :city)');
        $query->execute([
            'number' => $user->getAddress()->getNumber(),
            'street' => $user->getAddress()->getStreet(),
            'complement' => $user->getAddress()->getComplement(),
            'postale_code' => $user->getAddress()->getPostale_code(),
            'city' => $user->getAddress()->getCity()
        ]);
        
        // Obtenir l'ID de l'adresse insérée
        $addressId = $this->db->lastInsertId();
        
        $query = $this->db->prepare('INSERT INTO users (id, last_name, first_name, date_of_birth, email, password, address_id, phone, created_at, role) VALUES (NULL, :last_name, :first_name, :date_of_birth, :email, :password, :address_id, :phone, NOW(), :role)');
        $parameters = [
            "last_name" => $user->getLast_name(),
            "first_name" => $user->getFirst_name(),
            "date_of_birth" => $user->getDate_of_birth()->format('Y-m-d'),
            "password" => $user->getPassword(),
            "email" => $user->getEmail(),
            "address_id" => $addressId,
            "phone" => $user->getPhone(),
            "role" => $user->getRole(),
        ];

        // Exécution de la requête SQL
        $query->execute($parameters);
        
        // Récupérer l'ID du dernier utilisateur inséré
        $user->setId($this->db->lastInsertId());

        return $user;
    }
    
    //méthode qui permet de trouver un utilisateur dans la base de données à partir de son email.
    //Attention à bien respecter le prototype de la méthode, elle retourne soit null, soit un User et prend une string en paramètres
    public function findUserByEmail(string $email) : ? User
    {
        $query = $this->db->prepare('SELECT * FROM users WHERE email = :email');
        $parameters = [
            "email" => $email,
        ];
        $query->execute($parameters);
        $user = $query->fetch(PDO::FETCH_ASSOC);

        //!== false
        if($user)
        {
            $address = $this->findAddressById($user["address_id"]);
            $item = new User($user["last_name"], $user["first_name"], new DateTime($user["date_of_birth"]), $user["email"], $user["password"], $address, $user["phone"], new DateTime($user["created_at"]), $user["role"]);
            $item->setId($user["id"]);
            
            return $item;
        }
        else
        {
            return null;
        }
    }
    
    public function findAddressById(int $address_id): ?Address
    {
        $query = $this->db->prepare('SELECT * FROM address WHERE id = :id');
        $query->execute(['id' => $address_id]);
        $address = $query->fetch(PDO::FETCH_ASSOC);

        if ($address) {
            return new Address($address['number'], $address['street'], $address['complement'], $address['postale_code'], $address['city']);
        } else {
            return null;
        }
    }
    
    // Méthode qui permet de trouver tous les utilisateurs dans la base de données.
    // Retourne un tableau d'instances de la classe User
    public function findAllUsers() : array
    {
        $query = $this->db->prepare('SELECT * FROM users');
        $query->execute();
        $users = $query->fetchAll(PDO::FETCH_ASSOC);

        $userList = [];
        foreach ($users as $user) 
        {
            $address = $this->findAddressById($user["address_id"]);
            $item = new User($user["last_name"], $user["first_name"], new DateTime($user["date_of_birth"]), $user["email"], $user["password"], $address, $user["phone"], new DateTime($user["created_at"]), $user["role"]);
            $item->setId($user["id"]);
            $userList[] = $item;
        }

        return $userList;
    }
    
    //Méthode qui permet de trouver un utilisateur dans la base de données à partir de son id.
    public function findUserById(int $id): ? User
    {
        $query = $this->db->prepare('SELECT * FROM users WHERE id = :id');
        $parameters = [
            "id" => $id,
        ];
        $query->execute($parameters);
        $user = $query->fetch(PDO::FETCH_ASSOC);
        
        if ($user) 
        {
            
            $address = $this->findAddressById($user["address_id"]);
            $userInstance = new User($user["last_name"], $user["first_name"], new DateTime($user["date_of_birth"]), $user["email"], $user["password"], $address, $user["phone"], new DateTime($user["created_at"]), $user["role"]);
            $userInstance->setId($user["id"]);
        
            return $userInstance;
        
        }
        else 
        {
            return null;
        }
    }
    
    //Méthode pour modifier un utilisateur
    public function updateUser(User $user) : User
    {
        // Mettre à jour l'adresse
    $query = $this->db->prepare('UPDATE address SET number = :number, street = :street, complement = :complement, postal_code = :postal_code, city = :city  WHERE id = :id');
    $query->execute([
        'number' => $user->getAddress()->getNumber(),
        'street' => $user->getAddress()->getStreet(),
        'complement' => $user->getAddress()->getComplement(),
        'postale_code' => $user->getAddress()->getPostale_code(),
        'city' => $user->getAddress()->getCity(),
        'id' => $user->getAddress()->getId(),
    ]);
        
        $query = $this->db->prepare('UPDATE users SET last_name = :last_name, first_name= :first_name, date_of_birth= :date_of_birth, email = :email, password = :password, address_id= :address_id, phone= :phone, role = :role WHERE id = :id');
        $parameters = [
            "last_name" => $user->getLast_name(),
            "first_name" => $user->getFirst_name(),
            "date_of_birth" => $user->getDate_of_birth()->format('Y-m-d'),
            "password" => $user->getPassword(),
            "email" => $user->getEmail(),
            "address_id" => $user->getAddress()->getId(),
            "phone" => $user->getPhone(),
            "role" => $user->getRole(),
            "id" => $user->getId(),
            ];
            
            $query->execute($parameters);

        return $user;
    }
    
    // Méthode pour supprimer un utilisateur
    public function deleteUser(int $id) : void
    {
        $query = $this->db->prepare('DELETE users FROM users WHERE id = :id');
        $parameters = [
            "id" => $id,
        ];

        $query->execute($parameters);
    }
    
}