<?php
namespace Neutron\Widget\PageBlockBundle\Form\EventSubscriber\PageBlock;

use Symfony\Component\Form\FormEvent;

use Symfony\Component\Form\FormEvents;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class GeneralTypeSubscriber implements EventSubscriberInterface
{
    
    public function preSetData(FormEvent $event)
    {
        $form = $event->getForm();
        $data = $event->getData();
        
        if (empty($data)) {
            return;
        }
        
        if ($data->getId()){
            $form->remove('name');
        }
    }
    
    /**
     * Subscription for Form Events
     */
    static function getSubscribedEvents()
    {
        return array(
            FormEvents::PRE_SET_DATA => 'preSetData',
        );
    }
}