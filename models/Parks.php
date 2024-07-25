<?php

class Parks
{
    private ? int $id =null;

    public function __construct(private string $nom, private string $categorie, private string $distance, private string $commun, private string $site)
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
    
    public function getCategorie(): string
    {
        return $this->categorie;
    }

    public function setCategorie(string $categorie): void
    {
        $this->categorie = $categorie;
    }

    public function getDistance(): string
    {
        return $this->distance;
    }
 
    public function setDistance(string $distance): void
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

    public function getSite(): string
    {
        return $this->site;
    }

    public function setSite(string $site): void
    {
        $this->site = $site;
    }
}