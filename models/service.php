<?php

class service
{
    private ? int $id =null;

    public function __construct(private string $name, private string $icone)
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
        return $this ->name;
    }

    public function setName(string $name): void
    {
        $this -> name = $name;
    }
    
    public function getIcone(): string
    {
        return $this->icone;
    }

    public function setIcone(string $icone): void
    {
        $this->icone = $icone;
    }

}