<?php

namespace Neutron\Widget\PageBlockBundle\Controller\Backend;

use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\DependencyInjection\ContainerAware;

class AdministrationController extends ContainerAware
{
    
    public function indexAction()
    {    
        $grid = $this->container->get('neutron.datagrid')->get('page_block_management');
        
        $template = $this->container->get('templating')
            ->render('NeutronPageBlockBundle:Backend\Administration:index.html.twig', array(
                'grid' => $grid   
            )
        );
    
        return  new Response($template);
    }

}
