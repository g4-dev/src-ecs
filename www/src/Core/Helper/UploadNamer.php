<?php

namespace Core\Helper;

use Doctrine\Common\Persistence\ManagerRegistry;
use Vich\UploaderBundle\Mapping\PropertyMapping;
use Vich\UploaderBundle\Naming\DirectoryNamerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Vich\UploaderBundle\Util\Transliterator;

class UploadNamer implements DirectoryNamerInterface
{
    /**
     * @var ManagerRegistry
     */
    private $doctrine;
    
    /**
     * @var $user|null
     */
    private $user;
    
    /**
     * @param ManagerRegistry $doctrine
     */
    public function __construct(ManagerRegistry $doctrine, TokenStorageInterface $tokenStorage)
    {
        $this->doctrine = $doctrine;
        $this->user = $tokenStorage->getToken()->getUser();
    }
    
    public function directoryName($object, PropertyMapping $mapping): string
    {
        $userDirId = explode("@", $this->user->getEmail())[0] . RandomIdGenerator::generate();
        dump($userDirId);
        return sprintf('%s/%s/%s',
            $userDirId, $this->getShortClassName($object), $this->getIdentifier($object));
    }
    
    /**
     * Get short class name of given object :
     *  - Admin\Entity\Product : product
     *  - Core\Entity\User : user
     *
     * @param object $object
     *
     * @return string
     */
    private function getShortClassName($object): string
    {
        $fqcn = get_class($object);
        $classParts = explode('\\', $fqcn);
        
        return Transliterator::transliterate(array_pop($classParts));
    }
    
    /**
     * Get identifier given object.
     * Use Doctrine metadata as a generic method.
     *
     * @param object $object
     *
     * @return string
     */
    private function getIdentifier($object): string
    {
        $fqcn = get_class($object);
        $identifiers = $this->doctrine->getManagerForClass($fqcn)
           ->getClassMetadata($fqcn)
           ->getIdentifierValues($object);
        
        return Transliterator::transliterate(reset($identifiers));
    }
}