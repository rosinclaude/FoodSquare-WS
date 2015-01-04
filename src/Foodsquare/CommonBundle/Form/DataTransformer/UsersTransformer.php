<?php

namespace Foodsquare\CommonBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

use Doctrine\Common\Persistence\ObjectManager;



class UsersTransformer implements DataTransformerInterface
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
        $this->setEntityClass("Foodsquare\CommonBundle\Entity\Users");
        $this->setEntityRepository("FoodsquareCommonBundle:Users");
        $this->setEntityType("Users");
        
    }

    /**
     * Transforme un user  en id .
     *
     * @param  Users|null $user
     * @return string
     */
    public function transform($user)
    {
        if (null === $user) {
            return "";
        }

        return $user->getId();
    }

    /**
     * Transforme l'id User en objet Users.
     *
     * @param  string id
     *
     * @return Users|null
     *
     * @throws TransformationFailedException if object (Users) is not found.
     */
    public function reverseTransform($id)
    {
        
        $repository = $this->om->getRepository($this->entityRepository);
        $user = $repository->findOneById($id);
        
        if(is_null($user) || !is_object($user)){
            throw new TransformationFailedException(sprintf(
                    'Le récupération du User d\'identifiant "%s" a échoué',
                    $id
                ));
        }
        return $user;
    }
    
    public function setEntityType($entityType){$this->entityType = $entityType;}
 
    public function setEntityClass($entityClass){$this->entityClass = $entityClass;}
 
    public function setEntityRepository($entityRepository){$this->entityRepository = $entityRepository;}
   

}