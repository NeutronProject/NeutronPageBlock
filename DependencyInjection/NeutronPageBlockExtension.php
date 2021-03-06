<?php

namespace Neutron\Widget\PageBlockBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class NeutronPageBlockExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');
        
        if ($config['enable'] === false){
            return;
        }
        
        $container->setAlias('neutron_page_block.controller.backend.administration', $config['controller_administration']);
        $container->setAlias('neutron_page_block.controller.front', $config['controller_front']);
        $container->setAlias('neutron_page_block.manager', $config['manager']);
        $container->setParameter('neutron_page_block.block_class', $config['block_class']);
        $container->setParameter('neutron_page_block.block_reference_class', $config['block_reference_class']);
        $container->setParameter('neutron_page_block.templates', $config['templates']);

        $container->setAlias('neutron_page_block.form.handler.page_block', $config['form']['handler']);
        $container->setParameter('neutron_page_block.form.type.page_block', $config['form']['type']);
        $container->setParameter('neutron_page_block.page_block.form.name', $config['form']['name']);
    }
}
