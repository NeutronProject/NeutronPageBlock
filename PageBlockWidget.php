<?php
namespace Neutron\Widget\PageBlockBundle;

use Neutron\LayoutBundle\Event\ConfigureWidgetEvent;

use Neutron\LayoutBundle\LayoutEvents;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use Neutron\LayoutBundle\Widget\WidgetFactoryInterface;

use Neutron\LayoutBundle\Model\Widget\WidgetManagerInterface;

class PageBlockWidget
{
    protected $dispatcher;
    
    protected $factory; 
    
    protected $manager;

    public function __construct(EventDispatcherInterface $dispatcher, WidgetFactoryInterface $factory, 
        WidgetManagerInterface$manager)
    {
        $this->dispatcher = $dispatcher;
        $this->factory = $factory;
        $this->manager = $manager;
    }
    
    public function build()
    {
        $widget = $this->factory->createWidget('neutron.widget.block_page');
        $widget
            ->setLabel('widget.block_page.label')
            ->setDescription('widget.block_page.desc')
            ->setAdministrationRoute('neutron_page_block.administration')
            ->setFrontController('NeutronPageBlockBundle:Frontend\Default:index')
            ->setManager($this->manager)
            ->enablePluginAware(true)
            ->setAllowedPlugins(array('neutron.plugin.page'))
            ->enablePanelAware(true)
            ->setAllowedPanels(array('page_panel_sidebar_right', 'page_panel_static'))
        ;
        
        $this->dispatcher->dispatch(
            LayoutEvents::onWidgetConfigure,
            new ConfigureWidgetEvent($this->factory, $widget)
        );
        
        return $widget;
    }
}