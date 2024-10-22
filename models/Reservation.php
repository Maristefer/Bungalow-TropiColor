<?php

class Reservation
{
    private ? int $id = null;
    

    public function __construct(private User $user, private Bungalow $bungalow, private DateTime $start_date, private DateTime $end_date, private DateTime $created_at, private int $total_price)
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
    
    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

   public function getBungalow(): Bungalow
    {
        return $this->bungalow;
    }

    public function setBungalow(Bungalow $bungalow): void
    {
        $this->bungalow = $bungalow;
    }

    
    public function getStartDate(): DateTime
    {
        return $this->start_date;
    }

    public function setStartDate(DateTime $start_date): void
    {
        $this->start_date = $start_date;
    }

    public function getEndDate(): DateTime
    {
        return $this->end_date;
    }

    public function setEndDate(DateTime $end_date): void
    {
        $this->end_date = $end_date;
    }
    
     public function getCreatedAt(): DateTime
    {
        return $this->created_at;
    }

    public function setCreatedAt(DateTime $created_at): void
    {
        $this->created_at = $created_at;
    }
    
    public function getTotalPrice(): int
    {
        return $this->total_price;
    }

    public function setTotalPrice(int $total_price): void
    {
        $this->total_price = $total_price;
    }
}