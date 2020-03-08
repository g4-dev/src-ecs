<?php


namespace Admin\Event;

use Admin\Entity\Settings;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\EasyAdminEvents;
use Symfony\Component\EventDispatcher\GenericEvent;

class EasyAdminSubscriber implements EventSubscriberInterface
{
    private $slugger;
    
    public function __construct($slugger)
    {
        $this->slugger = $slugger;
    }
    
    public static function getSubscribedEvents()
    {
        return array(
           'easy_admin.pre_persist' => array('setSettings'),
        );
    }
    
    public function setSettings(GenericEvent $event)
    {
        $entity = $event->getSubject();
        
        if (!($entity instanceof Settings)) {
            return;
        }
        dump($entity);
        
        $event['entity'] = $entity;
    }
}