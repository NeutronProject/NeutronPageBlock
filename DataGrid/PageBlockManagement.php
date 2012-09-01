<?php
namespace Neutron\Widget\PageBlockBundle\DataGrid;

use Neutron\Widget\PageBlockBundle\Model\PageBlockManagerInterface;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Doctrine\ORM\Query;

use Symfony\Bundle\FrameworkBundle\Routing\Router;

use Symfony\Bundle\FrameworkBundle\Translation\Translator;

use Doctrine\ORM\EntityManager;

use Neutron\Bundle\DataGridBundle\DataGrid\FactoryInterface;

class PageBlockManagement
{

    protected $factory;

    protected $manager;
    
    protected $translator;
    
    protected $router;
    
    protected $session;
    
    protected $blockClass;
    
    protected $defaultLocale;


    public function __construct (FactoryInterface $factory, PageBlockManagerInterface $manager, 
            Translator $translator, Router $router, SessionInterface $session, $blockClass, $defaultLocale)
    {
        $this->factory = $factory;
        $this->manager = $manager;
        $this->translator = $translator;
        $this->router = $router;
        $this->session = $session;
        $this->blockClass = $blockClass;
        $this->defaultLocale = $defaultLocale;
    }

    public function build ()
    {
        
        /**
         *
         * @var DataGrid $dataGrid
         */
        $dataGrid = $this->factory->createDataGrid('page_block_management');
        $dataGrid->setCaption(
            $this->translator->trans('grid.page_block_management.title',  array(), 'NeutronPageBlockBundle')
        )
            ->setAutoWidth(true)
            ->setColNames(array(
                $this->translator->trans('grid.page_block_management.column.title',  array(), 'NeutronPageBlockBundle'),
                $this->translator->trans('grid.page_block_management.column.identifier',  array(), 'NeutronPageBlockBundle'),
                $this->translator->trans('grid.page_block_management.column.enabled',  array(), 'NeutronPageBlockBundle'),
  

            ))
            ->setColModel(array(
                array(
                    'name' => 'b.title', 'index' => 'b.title', 'width' => 200, 
                    'align' => 'left', 'sortable' => true, 'search' => true,
                ), 
                array(
                    'name' => 'b.identifier', 'index' => 'b.identifier', 'width' => 200, 
                    'align' => 'left', 'sortable' => true, 'search' => true,
                ),  
                array(
                    'name' => 'b.enabled', 'index' => 'b.enabled',  'width' => 40, 
                    'align' => 'left',  'sortable' => true, 
                    'formatter' => 'checkbox',  'search' => true, 'stype' => 'select',
                    'searchoptions' => array(
                        'value' => array(
                            1 => $this->translator->trans('grid.enabled', array(), 'NeutronPageBlockBundle'), 
                            0 => $this->translator->trans('grid.disabled', array(), 'NeutronPageBlockBundle')
                        )
                    )
                ),

            ))
            ->setQueryBuilder($this->manager->getQueryBuilderForPageBlockManagementDataGrid())
            ->setSortName('b.title')
            ->setSortOrder('asc')
            ->enablePager(true)
            ->enableViewRecords(true)
            ->enableSearchButton(true)
            ->enableAddButton(true)
            ->setAddBtnUri($this->router->generate('neutron_page_block.update', array(), true))
            ->enableEditButton(true)
            ->setEditBtnUri($this->router->generate('neutron_page_block.update', array('id' => '{id}'), true))
            ->enableDeleteButton(true)
            ->setDeleteBtnUri($this->router->generate('neutron_page_block.delete', array('id' => '{id}'), true))
            ->setQueryHints(array(
                Query::HINT_CUSTOM_OUTPUT_WALKER 
                    => 'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker',
                \Gedmo\Translatable\TranslatableListener::HINT_TRANSLATABLE_LOCALE 
                    => $this->session->get('frontend_language', $this->defaultLocale),
            ))

            ->setFetchJoinCollection(false)
        ;

        return $dataGrid;
    }


}