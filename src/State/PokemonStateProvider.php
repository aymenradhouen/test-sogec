<?php

namespace App\State;

use ApiPlatform\Doctrine\Orm\State\CollectionProvider;
use ApiPlatform\Metadata\CollectionOperationInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Entity\Pokemon;
use App\Repository\PokemonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class PokemonStateProvider implements ProviderInterface
{
    private $pokemonRepository;
    private $security;
    private $itemProvider;
    private $collectionProvider;
    public function __construct(PokemonRepository $pokemonRepository, Security $security,
                                ProviderInterface $itemProvider, CollectionProvider $collectionProvider)
    {
        $this->pokemonRepository = $pokemonRepository;
        $this->security = $security;
        $this->itemProvider = $itemProvider;
        $this->collectionProvider = $collectionProvider;
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        if ($operation instanceof CollectionOperationInterface) {
            if($this->security->getUser()){
                return $this->collectionProvider->provide($operation, $uriVariables, $context);
            } else {
                $queryBuilder = $this->pokemonRepository->createQueryBuilder('p');
                $queryBuilder->where('p.legendary = false');
                $queryBuilder->setMaxResults($context['filters']['itemsPerPage']);
                $queryBuilder->setFirstResult(($context['filters']['page']-1)*$context['filters']['itemsPerPage']);
                $queryBuilder->leftJoin('p.type', 't');
                foreach ($context['filters'] as $key => $filter){
                    if($key != 'page' && $key != 'itemsPerPage' && $key != 'legendary'){
                        if($key == 'type.type1'){
                            $queryBuilder->andWhere("t.type1 LIKE '%".$filter."%'");
                        } else if($key == 'type.type2'){
                            $queryBuilder->andWhere("t.type2 LIKE '%".$filter."%'");
                        } else {
                            $queryBuilder->andWhere("p.".$key." LIKE '%".$filter."%'");
                        }
                    }
                }
                return $queryBuilder->getQuery()->getResult();
            }
        }

        $pokemon = $this->itemProvider->provide($operation, $uriVariables, $context);
        if($pokemon){
            if($this->security->getUser()){
                return $pokemon;
            } else {
                if($pokemon->getLegendary()){
                    return ['message' => 'Cannot get the pokemon because it\'s a legendary one'];
                }
            }
        } else {
            return ['message' => 'Pokemon not found'];
        }
    }
}
