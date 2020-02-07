<?php


namespace Admin\Event;

use Admin\Entity\CmsPage;
use Core\Model\Sluggable;
use Core\Helper\Slugger;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\EasyAdminEvents;
use Symfony\Component\EventDispatcher\GenericEvent;

class EasyAdminSubscriber implements EventSubscriberInterface
{
    
    public static function getSubscribedEvents()
    {
        return [
           EasyAdminEvents::PRE_UPDATE => 'onPreUpdate',
        ];
    }
    
    public function onPreUpdate(GenericEvent $event)
    {
        //TODO: load more specific data in easyadmin by subscribing events
        dump($event);
        $entity = $event->getSubject();
        // TODO: create a sluggable interface
        if ($entity instanceof Sluggable) {
            echo "triggered sluggable entity";
        }
    }
}