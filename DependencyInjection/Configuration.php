<?php

namespace Ylly\Bundle\MailboxLayer\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();

        $rootNode = $treeBuilder->root('mailbox_layer');

        $rootNode
            ->children()
                ->scalarNode('access_key')
                    ->info('The access_key must be generated on the website of the API mailboxlayer : see https://mailboxlayer.com/product')
                ->end()
                ->scalarNode('proxy')
                    ->defaultNull()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
