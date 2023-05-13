<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\PokemonRepository;
use App\State\PokemonState;
use App\State\PokemonStateProvider;
use App\State\UserPasswordHasher;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PokemonRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(provider: PokemonStateProvider::class),
        new Get(provider: PokemonStateProvider::class),
        new Put(),
        new Patch(),
    ],
    paginationItemsPerPage: 50,
)]
class Pokemon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string',length: 50)]
    private $name;

    #[ORM\ManyToOne(targetEntity: Type::class)]
    private $type;

    #[ORM\ManyToOne(targetEntity: Statistique::class)]
    private $statistique;

    #[ORM\Column(type: 'integer',length: 5)]
    private $generation;

    #[ORM\Column(type: 'boolean')]
    private $legendary;


    /**
     * @param $name
     * @param $statistique
     */
    public function __construct($name, $type, $statistique, $generation, $legendary)
    {
        $this->name = $name;
        $this->type = $type;
        $this->statistique = $statistique;
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
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type): void
    {
        $this->type = $type;
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



}
