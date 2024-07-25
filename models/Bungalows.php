<?php

class Bungalows
{
    private ? int $id =null;

    public function __construct(private string $name, private string $description, private int $photo_id, private string $capacite, private int $prix, private int $vehicule_id, private string $surface)
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

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;

    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getPhoto_id(): int
    {
        return $this->photo_id;
    }

    public function setPhoto_id(int $photo_id): void
    {
        $this->photo_id = $photo_id;
    }

    public function getCapacite(): string
    {
        return $this->capacite;
    }

    public function setCapacite(string $capacite): void
    {
        $this->capacite = $capacite;
    }

    public function getPrix(): int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): void
    {
        $this->prix = $prix;
    }

    public function getVehicule_id(): int
    {
        return $this->vehicule_id;
    }

    public function setVehicule_id(int $vehicule_id): void
    {
        $this->vehicule_id = $vehicule_id;
    }

    public function getSurface(): string
    {
        return $this->surface;
    }

    public function setSurface(string $surface): void
    {
        $this->surface = $surface;
    }
}