<?php

namespace App\Entity;

use App\Repository\StatistiqueRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StatistiqueRepository::class)]
class Statistique
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer',length: 5,nullable: true)]
    private $total;

    #[ORM\Column(type: 'integer',length: 5)]
    private $hp;

    #[ORM\Column(type: 'integer',length: 5)]
    private $attack;

    #[ORM\Column(type: 'integer',length: 5)]
    private $defense;

    #[ORM\Column(type: 'integer',length: 5)]
    private $spAtk;

    #[ORM\Column(type: 'string',length: 50)]
    private $spDef;

    #[ORM\Column(type: 'integer',length: 5)]
    private $speed;

    #[ORM\Column(type: 'integer',length: 5)]
    private $generation;

    #[ORM\Column(type: 'boolean')]
    private $legendary;

    #[ORM\OneToMany(targetEntity: Pokemon::class, mappedBy: 'statistique')]
    private $statistiques;

    /**
     * @param $total
     * @param $hp
     * @param $attack
     * @param $defense
     * @param $spAtk
     * @param $spDef
     * @param $speed
     * @param $generation
     * @param $legendary
     */
    public function __construct($total, $hp, $attack, $defense, $spAtk, $spDef, $speed, $generation, $legendary)
    {
        $this->total = $total;
        $this->hp = $hp;
        $this->attack = $attack;
        $this->defense = $defense;
        $this->spAtk = $spAtk;
        $this->spDef = $spDef;
        $this->speed = $speed;
        $this->generation = $generation;
        $this->legendary = $legendary;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param mixed $total
     */
    public function setTotal($total): void
    {
        $this->total = $total;
    }

    /**
     * @return mixed
     */
    public function getHp()
    {
        return $this->hp;
    }

    /**
     * @param mixed $hp
     */
    public function setHp($hp): void
    {
        $this->hp = $hp;
    }

    /**
     * @return mixed
     */
    public function getAttack()
    {
        return $this->attack;
    }

    /**
     * @param mixed $attack
     */
    public function setAttack($attack): void
    {
        $this->attack = $attack;
    }

    /**
     * @return mixed
     */
    public function getDefense()
    {
        return $this->defense;
    }

    /**
     * @param mixed $defense
     */
    public function setDefense($defense): void
    {
        $this->defense = $defense;
    }

    /**
     * @return mixed
     */
    public function getSpAtk()
    {
        return $this->spAtk;
    }

    /**
     * @param mixed $spAtk
     */
    public function setSpAtk($spAtk): void
    {
        $this->spAtk = $spAtk;
    }

    /**
     * @return mixed
     */
    public function getSpDef()
    {
        return $this->spDef;
    }

    /**
     * @param mixed $spDef
     */
    public function setSpDef($spDef): void
    {
        $this->spDef = $spDef;
    }

    /**
     * @return mixed
     */
    public function getSpeed()
    {
        return $this->speed;
    }

    /**
     * @param mixed $speed
     */
    public function setSpeed($speed): void
    {
        $this->speed = $speed;
    }

    /**
     * @return mixed
     */
    public function getGeneration()
    {
        return $this->generation;
    }

    /**
     * @param mixed $generation
     */
    public function setGeneration($generation): void
    {
        $this->generation = $generation;
    }

    /**
     * @return mixed
     */
    public function getLegendary()
    {
        return $this->legendary;
    }

    /**
     * @param mixed $legendary
     */
    public function setLegendary($legendary): void
    {
        $this->legendary = $legendary;
    }

    /**
     * @return mixed
     */
    public function getStatistiques()
    {
        return $this->statistiques;
    }

    /**
     * @param mixed $statistiques
     */
    public function setStatistiques($statistiques): void
    {
        $this->statistiques = $statistiques;
    }


}
