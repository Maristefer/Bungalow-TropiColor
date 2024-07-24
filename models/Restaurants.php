<?php

class Restaurants
{
    private ? int $id =null;

    public function __construct(private string $nom, private string $typeCuisine, private int $distance, private string $commun, private string $siteWeb)
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
    
    public function getTypeCuisine(): string
    {
        return $this->typeCuisine;
    }

    public function setTypeCuisine(string $typeCuisine): void
    {
        $this->typeCuisine = $typeCuisine;
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

    public function getSiteWeb(): string
    {
        return $this->siteWeb;
    }

    public function setSiteWeb(string $siteWeb): void
    {
        $this->siteWeb = $siteWeb;
    }
}