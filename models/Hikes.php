<?php

class Hikes
{
    private ? int $id =null;

    public function __construct(private string $nom, private string $commun, private string $distance, private string $duree, private string $niveau, private string $site)
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
    
    public function getCommun(): string
    {
        return $this->commun;
    }

    public function setCommun(string $commun): void
    {
        $this->commun = $commun;
    }
    
    public function getDistance(): string
    {
        return $this->distance;
    }
 
    public function setDistance(string $distance): void
    {
        $this->distance = $distance;
    }
    
    public function getDuree(): string
    {
        return $this->duree;
    }

    public function setDuree(string $duree): void
    {
        $this->duree = $duree;
    }
    
    public function getNiveau(): string
    {
        return $this->niveau;
    }
    
    public function setNiveau(string $niveau): void
    {
        $this->niveau = $niveau;
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