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
    
    public function get($identifier)
    {
        return $this->findOneBy(array('identifier' => $identifier));
    }
    
    public function getInstances($locale)
    {
        return $this->repository->getInstances($locale);
    }

    public function getQueryBuilderForPageBlockManagementDataGrid()
    {
        return $this->repository->getPageBlockManagementQueryBuilder();
    }
 
    public function getPageBlock($identifier, $locale)
    {
        return $this->repository->getPageBlock($identifier, $locale);
    }
    
}

