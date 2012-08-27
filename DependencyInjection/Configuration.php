<?php

namespace Neutron\Widget\PageBlockBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('neutron_page_block');

        $this->addGeneralConfigurations($rootNode);

        return $treeBuilder;
    }
    
    private function addGeneralConfigurations(ArrayNodeDefinition $node)
    {
        $node
            ->addDefaultsIfNotSet()
            ->children()
                ->booleanNode('enable')->defaultFalse()->end()
                ->scalarNode('controller_administration')->defaultValue('neutron_page_block.controller.backend.administration.default')->end()
                ->scalarNode('manager')->defaultValue('neutron_page_block.manager.default')->end()
                ->scalarNode('block_class')->defaultValue('Neutron\Widget\PageBlockBundle\Entity\PageBlock')->end()
                ->scalarNode('block_reference_class')->defaultValue('Neutron\Widget\PageBlockBundle\Entity\PageBlockReference')->end()
    
            ->end()
        ;
    }
}
