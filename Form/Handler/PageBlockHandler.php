<?php
namespace Neutron\Widget\PageBlockBundle\Form\Handler;

use Neutron\Widget\PageBlockBundle\Model\PageBlockManagerInterface;

use Symfony\Component\Translation\TranslatorInterface;

use Doctrine\ORM\EntityManager;

use Symfony\Component\Security\Acl\Domain\ObjectIdentity;

use Neutron\AdminBundle\Acl\AclManagerInterface;

use Neutron\ComponentBundle\Form\Handler\FormHandlerInterface;

use Neutron\ComponentBundle\Form\Helper\FormHelper;

use Symfony\Bundle\FrameworkBundle\Routing\Router;

use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Form\Form;

use Symfony\Component\HttpFoundation\Request;

class PageBlockHandler implements FormHandlerInterface
{
    
    protected $em;
    
    protected $request;
    
    protected $router;
    
    protected $translator;
    
    protected $form;
    
    protected $formHelper;
    
    protected $pageBlockManager;
    
    protected $aclManager;
    
    protected $mode = self::MODE_CREATE;
    
    protected $result;


    public function __construct(EntityManager $em, Form $form, FormHelper $formHelper, Request $request, Router $router, 
            TranslatorInterface $translator, PageBlockManagerInterface $pageBlockManager, AclManagerInterface $aclManager)
    {
        $this->em = $em;
        $this->form = $form;
        $this->formHelper = $formHelper;
        $this->request = $request;
        $this->router = $router;
        $this->translator = $translator;
        $this->pageBlockManager = $pageBlockManager;
        $this->aclManager = $aclManager;

    }

    public function process()
    {
        if ($this->request->isXmlHttpRequest()) {
            
            $this->form->bind($this->request);
 
            if ($this->form->isValid()) {
                
                $this->onSucess();
                
                $this->request->getSession()
                    ->getFlashBag()->add('neutron.form.success', array(
                        'type' => 'success',
                        'body' => $this->translator->trans($this->mode, array(), 'NeutronPageBlockBundle')
                    ));
                
                $this->result = array(
                    'success' => true,
                    'redirect_uri' => 
                        $this->router->generate('neutron_page_block.administration')
                );
                
                return true;
  
            } else {
                $this->result = array(
                    'success' => false,
                    'errors' => $this->formHelper->getErrorMessages($this->form, 'NeutronPageBlockBundle')
                );
                
                return false;
            }
  
        }
    }
    
    protected function onSucess()
    {
        $pageBlockManager = $this->pageBlockManager;
        $aclManager = $this->aclManager;

        $block = $this->form->get('general')->getData();
        $acl = $this->form->get('acl')->getData();
        
        $this->em->transactional(function(EntityManager $em)
            use ($pageBlockManager, $aclManager, $block, $acl){
        
            $pageBlockManager->update($block);
            $aclManager
                ->setObjectPermissions(ObjectIdentity::fromDomainObject($block), $acl);
        });
    }
    
    public function setMode($mode)
    {
        $this->mode = $mode;
        return $this;
    }
    
    public function getResult()
    {
        return $this->result;
    }

   
}
