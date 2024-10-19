<?php

class Bungalow
{
    private ? int $id = null;

    public function __construct(private string $name, private string $description, private ? int $photo_id, private int $capacity, private int $price, private ? int $car_id, private string $surface)
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

    public function getPhoto_id(): ? int
    {
        return $this->photo_id;
    }

    public function setPhoto_id(?int $photo_id): void
    {
        $this->photo_id = $photo_id;
    }

    public function getCapacity(): int
    {
        return $this->capacity;
    }

    public function setCapacity(int $capacity): void
    {
        $this->capacity = $capacity;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function setPrice(int $price): void
    {
        $this->price = $price;
    }

    public function getCar_id(): ? int
    {
        return $this->car_id;
    }

    public function setCar_id(?int $car_id): void
    {
        $this->car_id = $car_id;
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