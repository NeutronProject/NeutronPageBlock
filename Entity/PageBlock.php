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

use Neutron\Bundle\FormBundle\Model\MultiSelectSortableInterface;

use Doctrine\Common\Collections\ArrayCollection;

use Gedmo\Mapping\Annotation as Gedmo;

use Doctrine\ORM\Mapping as ORM;

/**
 * @Gedmo\TranslationEntity(class="Neutron\Widget\PageBlockBundle\Entity\Translation\PageBlockTranslation")
 * @ORM\Table(name="neutron_widget_page_block")
 * @ORM\Entity(repositoryClass="Neutron\Widget\PageBlockBundle\Entity\Repository\PageBlockRepository")
 * 
 */
class PageBlock implements PageBlockInterface  
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
     * @var string 
     *
     * @ORM\Column(type="string", name="widget_identifier", length=50, nullable=false, unique=true)
     */
    protected $identifier;
    
    /**
     * @var string 
     * 
     * @Gedmo\Translatable
     * @ORM\Column(type="string", name="title", length=255, nullable=true, unique=false)
     */
    protected $title; 
    
    /**
     * @var string 
     *
     * @ORM\Column(type="string", name="template", length=255, nullable=false, unique=false)
     */
    protected $template;
    
    /**
     * @var boolean 
     *
     * @ORM\Column(type="boolean", name="enabled")
     */
    protected $enabled = false;
        
    /**
     * @ORM\OneToMany(targetEntity="PageBlockReference", mappedBy="pageBlock", cascade={"persist", "remove", "merge"}, orphanRemoval=true)
     * @ORM\OrderBy({"position" = "ASC"})
     */  
    protected $pageReferences; 
    
    public function __construct()
    {
        $this->pageReferences = new ArrayCollection();
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function setIdentifier($identifier)
    {
        $this->identifier = (string) $identifier;
    }
    
    public function getIdentifier()
    {
        return $this->identifier;
    }
   
    
    public function getLabel()
    {
        return $this->title;
    }
    
    public function setTitle($title)
    {
        $this->title = (string) $title;
    }
    
    public function getTitle()
    {
        return $this->title;
    }    
    
    public function setTemplate($template)
    {
        $this->template = (string) $template;
    }
    
    public function getTemplate()
    {
        return $this->template;
    }
    
    public function setEnabled($bool)
    {
        $this->enabled = (bool) $bool; 
    }
    
    public function isEnabled()
    {
        return $this->enabled;
    }
    
    public function getPageReferences()
    {
        return $this->pageReferences;
    }
    
    public function addPageReference(MultiSelectSortableInterface $reference)
    {
        if (!$this->pageReferences->contains($reference)){
            $this->pageReferences->add($reference);
            $reference->setPageBlock($this);
        }
        
        return $this;
    }
    
    public function removePageReference(MultiSelectSortableInterface $reference)
    {
        if ($this->pageReferences->contains($reference)){
            $this->pageReferences->removeElement($reference);
        }
        
        return $this;
    }
    
    
}