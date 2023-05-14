<?php

namespace App\State;

use ApiPlatform\Metadata\DeleteOperationInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Pokemon;
use App\Entity\Type;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;

class PokemonStateProcessor implements ProcessorInterface
{
    private $em;
    private $security;
    private $persistProcessor;
    private $removeProcessor;
    public function __construct(EntityManagerInterface $em, Security $security,
                                ProcessorInterface $persistProcessor, ProcessorInterface $removeProcessor)
    {
        $this->em = $em;
        $this->security = $security;
        $this->persistProcessor = $persistProcessor;
        $this->removeProcessor = $removeProcessor;
    }


    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        if ($operation instanceof DeleteOperationInterface) {
            if(!$data->getLegendary()) {
                return $this->removeProcessor->process($data, $operation, $uriVariables, $context);
            }
        }
        $type = $this->em->getRepository(Type::class)->findOneBy(['type1' => $data->getType()->getType1(),'type2' => $data->getType()->getType2()]);
        if($type){
            $data->setType($type);
            return $this->persistProcessor->process($data, $operation, $uriVariables, $context);
        }
    }
}
