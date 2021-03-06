<?php
/*
 * This file is part of NeutronPageBlockBundle
 *
 * (c) Zender <azazen09@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Neutron\Widget\PageBlockBundle\Entity\Repository;

use Symfony\Component\Security\Acl\Permission\MaskBuilder;

use Neutron\ComponentBundle\Doctrine\ORM\Query\TreeWalker\AclWalker;

use Doctrine\ORM\Query;

use Gedmo\Translatable\Entity\Repository\TranslationRepository;

class PageBlockRepository extends TranslationRepository
{
    public function getInstancesQueryBuilder()
    {
        $qb = $this->createQueryBuilder('b');
        $qb
            ->select('b.identifier, b.title as label')
            ->where('b.enabled = ?1')
            ->orderBy('b.title', 'ASC')
            ->setParameters(array(
                1 => true        
            ))
        ;
        
        return $qb;
    }
    
    public function getInstancesQuery($locale)
    {
        $query = $this->getInstancesQueryBuilder()->getQuery();
        $query->setHint(
            Query::HINT_CUSTOM_OUTPUT_WALKER,
            'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker'
        );
        $query->setHint(
            \Gedmo\Translatable\TranslatableListener::HINT_TRANSLATABLE_LOCALE,
            $locale
        );
        
        return $query;
    }
    
    public function getInstances($locale)
    {
        return $this->getInstancesQuery($locale)->getArrayResult();
    }
    
    public function getPageBlockManagementQueryBuilder()
    {
        $qb = $this->createQueryBuilder('b');
        
        $qb
            ->select('b.id, b.title, b.identifier, b.enabled')
        ;
        
        return $qb;
    }
    
    public function getPageBlockQueryBuilder($identifier)
    {
        $qb = $this->createQueryBuilder('b');
        $qb
            ->select('b, r, p')
            ->join('b.pageReferences', 'r')
            ->join('r.reference', 'p')
            ->where('b.identifier = ?1 AND b.enabled = ?2 AND r.isActive = ?3')
            ->orderBy('r.position', 'ASC')
            ->setParameters(array(
                1 => $identifier,
                2 => true,
                3 => true        
           ))
        ;
        
        return $qb;
    }
    
    public function getPageBlockQuery($identifier, $locale)
    {
        $query = $this->getPageBlockQueryBuilder($identifier)->getQuery();
        $query->setHint(
            Query::HINT_CUSTOM_OUTPUT_WALKER, 
            'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker'
        );
        $query->setHint(
            \Gedmo\Translatable\TranslatableListener::HINT_TRANSLATABLE_LOCALE,
            $locale
        );

        return $query;
    }
    
    public function getPageBlock($identifier, $locale)
    {
        return $this->getPageBlockQuery($identifier, $locale)->getOneOrNullResult();
    }
}