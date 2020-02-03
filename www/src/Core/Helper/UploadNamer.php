<?php

namespace Core\Helper;

use Doctrine\Common\Persistence\ManagerRegistry;
use Vich\UploaderBundle\Mapping\PropertyMapping;
use Vich\UploaderBundle\Naming\DirectoryNamerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

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
     * @var $user|null
     */
    private $session;
    
    /**
     * @param ManagerRegistry $doctrine
     */
    public function __construct(ManagerRegistry $doctrine, TokenStorageInterface $tokenStorage, SessionInterface $session)
    {
        $this->doctrine = $doctrine;
        $this->user = $tokenStorage->getToken()->getUser();
        $this->session = $session;
    
    }
    
    public function directoryName($object, PropertyMapping $mapping): string
    {
        $userDirId = explode("@", $this->user->getEmail())[0];
        $directoryName = sprintf('%s/%s', $userDirId, $this->getShortClassName($object));
        dump($directoryName);
        //$this->session->set('full_temp_path', $directoryName);
        
        return $directoryName;
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
        //array_pop($classParts);
        return (string) strtolower(end($classParts));
    }
}