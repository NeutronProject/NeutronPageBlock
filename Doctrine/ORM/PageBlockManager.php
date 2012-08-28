<?php
namespace Neutron\Widget\PageBlockBundle\Doctrine\ORM;

use Neutron\Widget\PageBlockBundle\Model\PageBlockInterface;

use Doctrine\ORM\EntityManager;

use Neutron\Widget\PageBlockBundle\Model\PageBlockManagerInterface;

class PageBlockManager implements PageBlockManagerInterface
{
    protected $em;
    
    protected $repository;
    
    protected $meta;
     
    protected $className;
    
    public function __construct(EntityManager $em, $class)
    {
        $this->em = $em;
        $this->repository = $this->em->getRepository($class);
        $this->meta = $this->em->getClassMetadata($class);
        $this->className = $this->meta->name;
    }
    
    public function create()
    {
        $class = $this->className;
        $entity = new $class;
        
        return $entity;
    }
    
    public function update(PageBlockInterface $entity)
    {
        $this->em->persist($entity);
        $this->em->flush();
    }
    
    public function delete(PageBlockInterface $entity)
    {
        $this->em->remove($entity);
        $this->em->flush();
    }
    
    public function findOneBy(array $criteria)
    {
        return $this->repository->findOneBy($criteria);
    }
    
    public function getQueryBuilderForPageBlockManagementDataGrid()
    {
        return $this->repository->getPageBlockManagementQueryBuilder();
    }
    
    public function getInstances()
    {
        $instances = array();
        $entities = $this->repository->findBy(array('enabled' => true), array('title' => 'ASC'));
        
        foreach ($entities as $entity){
            $instances[$entity->getId()] = $entity->getTitle();
        }
        
        return $instances;
    }
    
    public function getPageBlock($id, $locale)
    {
        return $this->repository->getPageBlock($id, $locale);
    }
    
}

