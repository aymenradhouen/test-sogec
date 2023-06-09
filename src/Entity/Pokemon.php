<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Put;
use App\Repository\PokemonRepository;
use App\State\PokemonStateProcessor;
use App\State\PokemonStateProvider;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PokemonRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(provider: PokemonStateProvider::class),
        new Get(provider: PokemonStateProvider::class),
        new Put(security: 'is_granted("ROLE_USER")',processor: PokemonStateProcessor::class),
        new Delete(security: 'is_granted("ROLE_USER")',processor: PokemonStateProcessor::class),
    ],
    denormalizationContext: ['groups' => ['pokemon:update']],
    paginationClientItemsPerPage: 50,
    paginationItemsPerPage: 50
)]
class Pokemon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[Groups(['pokemon:update'])]
    #[ApiFilter(SearchFilter::class, strategy: 'partial')]
    #[ORM\Column(type: 'string',length: 50)]
    private $name;

    #[Groups(['pokemon:update'])]
    #[ApiFilter(SearchFilter::class, properties: ['type.type1' => 'ipartial', 'type.type2' => 'ipartial'])]
    #[ORM\ManyToOne(targetEntity: Type::class)]
    private $type;

    #[ORM\ManyToOne(targetEntity: Statistique::class)]
    private $statistique;

    #[Groups(['pokemon:update'])]
    #[ApiFilter(SearchFilter::class, strategy: 'partial')]
    #[ORM\Column(type: 'integer')]
    private $generation;

    #[Groups(['pokemon:update'])]
    #[ApiFilter(BooleanFilter::class)]
    #[ORM\Column(type: 'boolean')]
    private $legendary;


    public function __construct($name = null, $type = null, $statistique = null, $generation = null, $legendary = null)
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
