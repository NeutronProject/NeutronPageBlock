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

use Gedmo\Translatable\Entity\Repository\TranslationRepository;

class PageBlockRepository extends TranslationRepository
{
    public function getPageBlockManagementQueryBuilder()
    {
        $qb = $this->createQueryBuilder('b');
        
        $qb
            ->select('b.id, b.title, b.type, COUNT(b.id) as num, b.enabled')
            ->join('b.pageReferences', 'p')
            ->groupBy('b.id')
        ;
        
        return $qb;
    }
}