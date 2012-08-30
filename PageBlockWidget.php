<?php
namespace Neutron\Widget\PageBlockBundle;

use Neutron\LayoutBundle\Event\ConfigureWidgetEvent;

use Neutron\LayoutBundle\LayoutEvents;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use Neutron\LayoutBundle\Widget\WidgetFactoryInterface;

class PageBlockWidget
{
    protected $dispatcher;
    
    protected $factory; 
    
    protected $managerService;


    public function __construct(EventDispatcherInterface $dispatcher, WidgetFactoryInterface $factory, 
            $managerService)
    {
        $this->dispatcher = $dispatcher;
        $this->factory = $factory;
        $this->managerService = $managerService;
    }
    
    public function build()
    {
        $widget = $this->factory->createWidget('neutron.widget.block_page');
        $widget
            ->setLabel('widget.block_page.label')
            ->setDescription('widget.block_page.desc')
            ->setAdministrationRoute('neutron_page_block.administration')
            ->setFrontController('NeutronPageBlockBundle:Frontend\Default:index')
            ->setManagerService($this->managerService)
            ->enablePluginAware(true)
            ->setDisplayOn(array('neutron.plugin.page'))
            ->setAllowedPanels(array('panel_sidebar_right'))
        ;
        
        $this->dispatcher->dispatch(
            LayoutEvents::onWidgetConfigure,
            new ConfigureWidgetEvent($this->factory, $widget)
        );
        
        return $widget;
    }
}