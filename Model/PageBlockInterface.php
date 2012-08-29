<?php
namespace Neutron\Widget\PageBlockBundle\Model;

use Neutron\LayoutBundle\Model\Widget\WidgetInstanceInterface;

use Neutron\Bundle\FormBundle\Model\MultiSelectSortableInterface;

interface PageBlockInterface extends WidgetInstanceInterface
{
    
    const TYPE_SORTABLE = 'type.sortable';
    
    public function setTitle($title);
    
    public function getTitle();
    
    public function setType($type);
    
    public function getType();
    
    public function setEnabled($bool);
    
    public function isEnabled();
    
    public function getPageReferences();
    
    public function addPageReference(MultiSelectSortableInterface $reference);
    
    public function removePageReference(MultiSelectSortableInterface $reference);
}