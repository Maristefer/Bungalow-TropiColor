<?php

class Media
{
    private ? int $id =null;

    public function __construct(private string $scr, private string $alt)
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
    
    public function getScr(): string
    {
        return $this ->scr;
    }

    public function setScr(string $scr): void
    {
        $this -> scr = $scr;
    }
    
    public function getAlt(): string
    {
        return $this->alt;
    }

    public function setAlt(string $alt): void
    {
        $this->alt = $alt;
    }
    


}