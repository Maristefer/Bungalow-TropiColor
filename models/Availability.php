<?php

class Availability
{
    private ? int $id =null;

    public function __construct(private int $bungalow_id, private DateTime $available_from, private DateTime $available_to, private bool $available)
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
    
    public function getBungalowId(): int
    {
        return $this ->bungalow_id;
    }

    public function setBungalowId(int $bungalow_id): void
    {
        $this -> bungalow_id = $bungalow_id;

    }
    
    public function getAvailableFrom(): DateTime
    {
        return $this->available_from;
    }

    public function setAvailableFrom(DateTime $available_from): void
    {
        $this->available_from = $available_from;

    }
    
    public function getAvailableTo(): DateTime
    {
        return $this->available_to;
    }

    public function setAvailableTo(DateTime $available_to): void
    {
        $this->available_to = $available_to;

    }

    public function isAvailable(): bool
    {
        return $this->available;
    }

    public function setAvailable(bool $available): void
    {
        $this->available = $available;

    }


}