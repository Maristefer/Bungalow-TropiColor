<?php

class Car
{
    private ? int $id =null;

    public function __construct(private string $brand, private string $type, private string $place, private int $price, private string $door, private int $photo_id)
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
    
    public function getBrand(): string
    {
        return $this -> brand;
    }

    public function setBrand(string $brand): void
    {
        $this -> brand = $brand;

    }
    
    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;

    }
    
    public function getPlace(): string
    {
        return $this->place;
    }

    public function setPlace(string $place): void
    {
        $this->place = $place;

    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function setPrice(int $price): void
    {
        $this->price = $price;

    }

    public function getDoor(): string
    {
        return $this->door;
    }

    public function setDoor(string $door): void
    {
        $this->door = $door;
    }
    
    public function getPhotoId(): int
    {
        return $this->photo_id;
    }

    public function setPhotoId(int $photo_id): void
    {
        $this->photo_id = $photo_id;
    }

}