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

use Neutron\Widget\PageBlockBundle\Entity\PageBlock;

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
class GeneralType extends AbstractType
{
    
    protected $pageBlockClass;
    
    public function __construct($pageBlockClass)
    {
        $this->pageBlockClass = $pageBlockClass;
    }
    
    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Form.AbstractType::buildForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array(
                'label' => 'form.title',
                'translation_domain' => 'NeutronPageBlockBundle'
            ))
            ->add('type', 'choice', array(
                'choices' => PageBlock::getTypes(),
                'multiple' => false,
                'expanded' => false,
                'attr' => array('class' => 'uniform'),
                'label' => 'form.type',
                'empty_value' => 'form.empty_value',
                'translation_domain' => 'NeutronPageBlockBundle'
            ))
            ->add('enabled', 'checkbox', array(
                'label' => 'form.enabled', 
                'value' => 1,
                'attr' => array('class' => 'uniform'),
                'translation_domain' => 'NeutronPageBlockBundle'
            ))
        ;
    }
    
    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Form.AbstractType::buildView()
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        
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
                return 'default';
            },
        ));
    }
    
    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Form.FormTypeInterface::getName()
     */
    public function getName()
    {
        return 'neutron_page_block_general';
    }
}