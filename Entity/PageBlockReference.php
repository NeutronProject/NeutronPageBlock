<?php
/*
 * This file is part of NeutronPageBlockBundle
 *
 * (c) Zender <azazen09@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Neutron\Widget\PageBlockBundle\Entity;

use Neutron\Widget\PageBlockBundle\Model\PageBlockInterface;

use Neutron\Plugin\PageBundle\Model\PageInterface;

use Neutron\Bundle\FormBundle\Model\MultiSelectSortableInterface;

use Gedmo\Mapping\Annotation as Gedmo;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="neutron_widget_page_block_reference")
 * @ORM\Entity()
 * 
 */
class PageBlockReference implements MultiSelectSortableInterface
{
    /**
     * @var integer 
     *
     * @ORM\Id @ORM\Column(name="id", type="integer")
     * 
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @var integer
     *
     * @ORM\Column(type="integer", name="position", length=10, nullable=false, unique=false)
     */
    protected $position = 0;
    
    /**
     * @var boolean 
     *
     * @ORM\Column(type="integer", name="is_active")
     */
    protected $isActive = false;
    
    /**
     * @ORM\ManyToOne(targetEntity="Neutron\Plugin\PageBundle\Entity\Page")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    protected $reference;
    
    /**
     * @ORM\ManyToOne(targetEntity="PageBlock", inversedBy="pageReferences",  cascade={"persist"})
     */   
    protected $pageBlock;
    
    public function getName()
    {
        return $this->reference->getTitle();
    }
    
    public function setPosition($position)
    {
        $this->position = (int) $position;
        return $this;
    }
    
    public function getPosition()
    {
        return $this->position;
    }
    
    public function setIsActive($bool)
    {
        $this->isActive = (bool) $bool;
        return $this;
    }
    
    public function getIsActive()
    {
        return $this->isActive;
    }
    
    public function setReference($reference)
    {
        if (!$reference instanceof PageInterface){
            throw new \InvalidArgumentException('Reference must be instance of PageInterface');
        }
        
        $this->reference = $reference;
        return $this;
    }
    
    public function getReference()
    {
        return $this->reference;
    }
    
    public function setPageBlock(PageBlockInterface $pageBlock)
    {
        $this->pageBlock = $pageBlock;
        return $this;
    }
    
    public function getPageBlock()
    {
        return $this->pageBlock;
    }
    
    
}