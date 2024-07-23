<?php

class Plages
{
    private ? int $id =null;

    public function __construct(private string $nom, private string $description, private int $distance, private string $commun, private string $url_localisation)
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
    
     
    public function getNom(): string
    {
        return $this->nom;
    }

    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }
    
    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getDistance(): int
    {
        return $this->distance;
    }
 
    public function setDistance(int $distance): void
    {
        $this->distance = $distance;
    }

    public function getCommun(): string
    {
        return $this->commun;
    }

    public function setCommun(string $commun): void
    {
        $this->commun = $commun;
    }

    public function getUrl_localisation(): string
    {
        return $this->url_localisation;
    }

    public function setUrl_localisation(string $url_localisation): void
    {
        $this->url_localisation = $url_localisation;
    }
}