<?php
/*
 * This file is part of NeutronPageBlockBundle
 *
 * (c) Zender <azazen09@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Neutron\Widget\PageBlockBundle\Form\Type\PageBlock;

use Neutron\Bundle\DataGridBundle\DataGrid\DataGridInterface;

use Symfony\Component\Form\FormView;

use Symfony\Component\Form\FormInterface;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\AbstractType;

/**
 * Short description
 *
 * @author Zender <azazen09@gmail.com>
 * @since 1.0
 */
class PagesType extends AbstractType
{
    
    protected $grid;
    
    protected $pageBlockClass;
    
    protected $pageBlockReferenceClass;
    
    protected $pageClass;
    
    public function __construct(DataGridInterface $grid, $pageBlockClass, $pageBlockReferenceClass, $pageClass)
    {
        $this->grid = $grid;
        $this->pageBlockClass = $pageBlockClass;
        $this->pageBlockReferenceClass = $pageBlockReferenceClass;
        $this->pageClass = $pageClass;
    }
    
    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Form.AbstractType::buildForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pageReferences', 'neutron_multi_select_sortable_collection', array(
                'label' => 'form.pageReferences', 
                'grid' => $this->grid,
                'options' => array(
                    'data_class' => $this->pageBlockReferenceClass,
                    'reference_data_class' => $this->pageClass
                )
            ))
        ;
    }
    
    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Form.AbstractType::setDefaultOptions()
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->pageBlockClass,
            'validation_groups' => function(FormInterface $form){
                return array('create', 'update');
            },
        ));
    }
    
    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Form.FormTypeInterface::getName()
     */
    public function getName()
    {
        return 'neutron_page_block_pages';
    }
}