<?php

namespace Foodsquare\CommonBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

use Doctrine\Common\Persistence\ObjectManager;



class RateThreadTransformer implements DataTransformerInterface
{
    /**
     *  Entité et Repository
     */
    private $entityClass;
    private $entityType;
    private $entityRepository;
    /**
     * @var ObjectManager
     */
    private $om;

    /**
     * @param ObjectManager om
     */
    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
        $this->setEntityClass("Foodsquare\CommonBundle\Entity\RateThread");
        $this->setEntityRepository("FoodsquareCommonBundle:RateThread");
        $this->setEntityType("RateThread");
        
    }

    /**
     * Transforme un thread  en id .
     *
     * @param  RateThread|null $thread
     * @return string
     */
    public function transform($thread)
    {
        if (null === $thread) {
            return "";
        }

        return $thread->getId();
    }

    /**
     * Transforme l'id thread en objet Thread.
     *
     * @param  string id
     *
     * @return RateThread|null
     *
     * @throws TransformationFailedException if object (RateThread) is not found.
     */
    public function reverseTransform($id)
    {
        
        $repository = $this->om->getRepository($this->entityRepository);
        $thread = $repository->findOneById($id);
        
        if(is_null($thread) || !is_object($thread)){
            throw new TransformationFailedException(sprintf(
                    'Le récupération du thread d\'identifiant "%s" a échoué',
                    $id
                ));
        }
        return $thread;
    }
    
    public function setEntityType($entityType){$this->entityType = $entityType;}
 
    public function setEntityClass($entityClass){$this->entityClass = $entityClass;}
 
    public function setEntityRepository($entityRepository){$this->entityRepository = $entityRepository;}
   

}