<?php


namespace Fixtures\DataFixtures\Dev;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Core\Entity\User;

class LoadUsers extends Fixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    private $container;
    
    public function getOrder()
    {
        return 10;
    }
    
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
    
    public function load(ObjectManager $manager)
    {
        $encoder = $this->container->get('security.password_encoder');
        
        foreach (range(0, 19) as $i) {
            $user = new User();
            $user->setName('user'.$i);
            $user->setFirstName('user'.$i);
            $user->setEmail('user'.$i.'@example.com');
            //$user->setActive(true);
            $user->setContract('contract'.($i % 5).'.pdf');
            
            $this->addReference('user-'.$i, $user);
            $manager->persist($user);
        }
    }
}