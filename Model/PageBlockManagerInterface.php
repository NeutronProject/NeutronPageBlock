<?php
namespace Neutron\Widget\PageBlockBundle\Model;

use Neutron\Widget\ContactBundle\Model\ContactManagerInterface;

use Neutron\Bundle\FormBundle\Model\MultiSelectSortableInterface;

interface PageBlockManagerInterface extends ContactManagerInterface
{
    public function create();
    
    public function update(PageBlockInterface $entity);
    
    public function delete(PageBlockInterface $entity);
    
    public function findOneBy(array $criteria);
    
    public function getQueryBuilderForPageBlockManagementDataGrid();
}