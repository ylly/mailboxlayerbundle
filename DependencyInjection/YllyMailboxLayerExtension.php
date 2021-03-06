<?php

namespace Ylly\Bundle\MailboxLayer\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\HttpKernel\Kernel;

class YllyMailboxLayerExtension extends Extension
{
    const NEW_FACTORY_SF_VERSION = 20600;

    /**
     * @param array $configs
     * @param ContainerBuilder $container
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        if (Kernel::VERSION_ID < self::NEW_FACTORY_SF_VERSION) {
            $loader->load('services_factory_legacy.yml');
        } else {
            $loader->load('services_factory.yml');
        }

        if ($this->hasMonologBundle($container->getParameter('kernel.bundles'))) {
            $loader->load('services_logger.yml');
            $definitionMonolog = $container->getDefinition('ylly.logger.monolog.mailbox_layer');
            $definitionMonolog->replaceArgument(1, $config['monolog_level']);
            $definitionMonolog->addTag('monolog.logger', ['channel' => $config['monolog_channel']]);
        }

        $definitionClient = $container->getDefinition('ylly.mailbox_layer');
        $definitionClient->replaceArgument(0, $config['access_key']);
        $definitionClient->replaceArgument(1, $config['proxy']);

        $taggedServices = $container->findTaggedServiceIds('ylly.logger');
        $definitionLogger = $container->getDefinition('ylly.logger.mailbox_layer');

        foreach ($taggedServices as $id => $tags) {
            $definitionLogger->addMethodCall('addLogger', [new Reference($id)]);
        }
    }

    private function hasMonologBundle($bundles)
    {
        foreach ($bundles as $bundle) {
            if (strpos($bundle, 'MonologBundle') !== false) {
                return true;
            }
        }

        return false;
    }
}
