<?php

declare(strict_types=1);

namespace CL\Bundle\MailerBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class RegisterMailerTypesPass implements CompilerPassInterface
{
    /**
     * @inheritdoc
     */
    public function process(ContainerBuilder $container)
    {
        $tag = 'cl_mailer.type';
        $typeRegistryId = 'cl_mailer.type_registry';

        if (!$container->has($typeRegistryId)) {
            die($typeRegistryId);
            return;
        }

        $definition = $container->findDefinition($typeRegistryId);

        $taggedServices = $container->findTaggedServiceIds($tag);

        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall('register', [new Reference($id)]);
        }
    }
}
