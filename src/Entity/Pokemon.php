<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\PokemonRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PokemonRepository::class)]
#[ApiResource]
class Pokemon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string',length: 50)]
    private $name;

    #[ORM\ManyToOne(targetEntity: Type::class, inversedBy: 'types')]
    private $type;

    #[ORM\ManyToOne(targetEntity: Statistique::class, inversedBy: 'statistiques')]
    private $statistique;

    /**
     * @param $name
     * @param $type1
     * @param $type2
     * @param $statistique
     */
    public function __construct($name, $type1, $type2, $statistique)
    {
        $this->name = $name;

        $this->statistique = $statistique;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getType1()
    {
        return $this->type1;
    }

    /**
     * @param mixed $type1
     */
    public function setType1($type1): void
    {
        $this->type1 = $type1;
    }

    /**
     * @return mixed
     */
    public function getType2()
    {
        return $this->type2;
    }

    /**
     * @param mixed $type2
     */
    public function setType2($type2): void
    {
        $this->type2 = $type2;
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
    public function getStatistique()
    {
        return $this->statistique;
    }

    /**
     * @param mixed $statistique
     */
    public function setStatistique($statistique): void
    {
        $this->statistique = $statistique;
    }


}
