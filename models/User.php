<?php

class User
{
    private ? int $id =null;

    public function __construct(private string $last_name, private string $first_name, private DateTime $date_of_birth, private string $email, private string $password, private int $address_id, private int $phone, private DateTime $created_at, private string $role)
    {
        
    }

    public function getId(): ? int
    {
        return $this -> id;
    }

    public function setId(?int $id): void
    {
        $this -> id = $id;
    }
    
    public function getLast_name(): string
    {
        return $this->last_name;
    }

    public function setLast_name(string $last_name): void
    {
        $this->last_name = $last_name;

    }
    
    public function getFirst_name(): string
    {
        return $this->first_name;
    }

    public function setFirst_name(string $first_name): void
    {
        $this->first_name = $first_name;

    }
    
    public function getDate_of_birth(): DateTime
    {
        return $this->date_of_birth;
    }

    public function setDate_of_birth(DateTime $date_of_birth): void
    {
        $this->date_of_birth = $date_of_birth;

    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;

    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }
    
    public function getAddress_id(): int
    {
        return $this->address_id;
    }

    public function setAddress_id(int $address_id): void
    {
        $this->address_id = $address_id;
    }

    public function getPhone(): int
    {
        return $this->phone;
    }

    public function setPhone(int $phone): void
    {
        $this->phone = $phone;
    }
    
    public function getCreated_at(): DateTime
    {
        return $this->created_at;
    }

    public function setCreated_at(DateTime $created_at): void
    {
        $this->created_at = $created_at;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function setRole(string $role): void
    {
        $this->role = $role;
    }

}