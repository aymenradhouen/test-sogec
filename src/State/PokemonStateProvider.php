<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Entity\Pokemon;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class PokemonStateProvider implements ProviderInterface
{
    private $em;
    private $security;
    public function __construct(EntityManagerInterface $em, Security $security)
    {
        $this->em = $em;
        $this->security = $security;
    }


    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        if(array_key_exists('id',$uriVariables)){
            $pokemon = $this->em->getRepository(Pokemon::class)->find($uriVariables['id']);
            if($this->security->getUser()){
                return $pokemon;
            } else {
                if($pokemon->getLegendary()){
                    return ['Cannot get the pokemon because it\'s a legendary one'];
                }
            }
        } else {
            if($this->security->getUser()){
                return $this->em->getRepository(Pokemon::class)->findBy([],[],$uriVariables['itemsPerPage'],$uriVariables['itemsPerPage']*($uriVariables['page']-1));
            } else {
                return $this->em->getRepository(Pokemon::class)->findBy(['legendary' => false],[],$uriVariables['itemsPerPage'],$uriVariables['itemsPerPage']*($uriVariables['page']-1));
            }
        }
    }
}
