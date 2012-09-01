<?php

namespace Neutron\Widget\PageBlockBundle\Controller\Backend;

use Neutron\ComponentBundle\Form\Handler\FormHandlerInterface;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Doctrine\ORM\EntityManager;

use Symfony\Component\HttpFoundation\RedirectResponse;

use Neutron\Widget\PageBlockBundle\Model\PageBlockManagerInterface;

use Neutron\Widget\PageBlockBundle\Model\PageBlockInterface;

use Symfony\Component\Security\Acl\Domain\ObjectIdentity;

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
    
    public function updateAction($id)
    {
        
        $manager = $this->container->get('neutron_page_block.manager');
        $form = $this->container->get('neutron_page_block.form.page_block');
        $handler = $this->container->get('neutron_page_block.form.handler.page_block');
        
        if (!$id){
            $block = $manager->create();
            $handler->setMode(FormHandlerInterface::MODE_CREATE);
        } else {
            $block = $manager->findOneBy(array('id' => $id));
            $handler->setMode(FormHandlerInterface::MODE_UPDATE);
        }
        
        if (!$block instanceof PageBlockInterface){
            throw new NotFoundHttpException();
        }
               
        $acl = $block->getId() ? $this->container->get('neutron_admin.acl.manager')
                ->getPermissions(ObjectIdentity::fromDomainObject($block)) : null;

        $form->setData(array(
            'general' => $block,
            'pages' => $block,
            'acl' => $acl
        ));
        
        if (null !== $handler->process()){
            return new Response(json_encode($handler->getResult()));
        }
        
        $template = $this->container->get('templating')
            ->render('NeutronPageBlockBundle:Backend\Administration:update.html.twig', array(
                'form' => $form->createView()
            )
        );
        
        return  new Response($template);
    }
    
    public function deleteAction($id)
    {
        $manager = $this->container->get('neutron_page_block.manager');
        $block = $manager->findOneBy(array('id' => $id));
        
        if (!$block instanceof PageBlockInterface){
            throw new NotFoundHttpException();
        }
        
        if ($this->container->get('request')->getMethod() == 'POST'){
            $this->doDelete($manager, $block);
            
            $this->container->get('session')
               ->getFlashBag()->add('neutron.form.success', array(
                    'type' => 'success',
                    'body' => $this->container->get('translator')
                       ->trans('flash.deleted', array(), 'NeutronPageBlockBundle')
                )
            );
            
            $redirectUrl = $this->container->get('router')->generate('neutron_page_block.administration');
            return new RedirectResponse($redirectUrl);
        }
        
        $template = $this->container->get('templating')
            ->render('NeutronPageBlockBundle:Backend\Administration:delete.html.twig', array(
                'record' => $block
            )
        );
        
        return  new Response($template);
    }
    
    protected function doDelete(PageBlockManagerInterface $pageBlockManager, PageBlockInterface $block)
    {
        $aclManager = $this->container->get('neutron_admin.acl.manager');
        $em = $this->container->get('doctrine.orm.entity_manager');
    
        $em->transactional(function(EntityManager $em) use ($pageBlockManager, $aclManager, $block){
            $aclManager->deleteObjectPermissions(ObjectIdentity::fromDomainObject($block));
            $pageBlockManager->delete($block);
        });
    }
    

}
