<?php

declare(strict_types=1);

namespace CL\Bundle\MailerBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class RegisterMailerTypesPass implements CompilerPassInterface
{
    const TAG_NAME = 'cl_mailer.type';
    const REGISTRY_ID = 'cl_mailer.type_registry';

    /**
     * @inheritdoc
     */
    public function process(ContainerBuilder $container)
    {
        $tag = self::TAG_NAME;
        $typeRegistryId = self::REGISTRY_ID;

        if (!$container->has($typeRegistryId)) {
            return;
        }

        $definition = $container->findDefinition($typeRegistryId);

        $taggedServices = $container->findTaggedServiceIds($tag);

        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall('register', [new Reference($id)]);
        }
    }
}
