<?php

class Address
{
    private ? int $id =null;

    public function __construct(private int $number, private string $street, private string $complement, private string $postal_code, private string $city)
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
    
    public function getNumber(): int
    {
        return $this -> number;
    }

    public function setNumber(int $number): void
    {
        $this -> number = $number;

    }
    
    public function getStreet(): string
    {
        return $this->street;
    }

    public function setStreet(string $street): void
    {
        $this->street = $street;

    }
    
    public function getComplement(): string
    {
        return $this->complement;
    }

    public function setComplement(string $complement): void
    {
        $this->complement = $complement;

    }

    public function getPostal_code(): string
    {
        return $this->postal_code;
    }

    public function setPostal_code(string $postal_code): void
    {
        $this->postal_code = $postal_code;

    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): void
    {
        $this->city = $city;
    }

}