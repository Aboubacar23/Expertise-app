<?php

namespace App\Entity;


class Chercher{

    /**
     * @var string|null
     */
    private $etat;

    /**
     * @var date|null
     */
    private $date_min;

    /**
     * @var date|null
     */
    private $date_max;
    
    /**
     * @var string|null
     */
    private $periodicite;


    /**
     * Get the value of etat
     *
     * @return  string|null
     */ 
    public function getEtat() : ?string
    {
        return $this->etat;
    }

    /**
     * Set the value of etat
     *
     * @param  string\null  $etat
     * @return  Chercher
     */ 
    public function setEtat(?string $etat) : Chercher
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get the value of date_max
     *
     * @return  date|null
     */ 
    public function getDateMax() : ?\DateTimeInterface
    {
        return $this->date_max;
    }

    /**
     * Set the value of date_max
     *
     * @param  date|null  $date_max
     * @return  Chercher
     */ 
    public function setDateMax(?\DateTimeInterface $date_max) : Chercher
    {
        $this->date_max = $date_max;

        return $this;
    }

    /**
     * Get the value of periodicite
     *
     * @return  string\null
     */ 
    public function getPeriodicite() : ?string
    {
        return $this->periodicite;
    }

    /**
     * Set the value of periodicite
     *
     * @param  string\null  $periodicite
     *
     * @return  Chercher
     */ 
    public function setPeriodicite(?string $periodicite) : Chercher
    {
        $this->periodicite = $periodicite;

        return $this;
    }

    /**
     * Get the value of date_min
     *
     * @return  date|null
     */ 
    public function getDateMin() : ?\DateTimeInterface
    {
        return $this->date_min;
    }

    /**
     * Set the value of date_min
     *
     * @param  date|null  $date_min
     *
     * @return  Chercher
     */ 
    public function setDateMin(?\DateTimeInterface $date_min) : Chercher
    {
        $this->date_min = $date_min;

        return $this;
    }
}

?>