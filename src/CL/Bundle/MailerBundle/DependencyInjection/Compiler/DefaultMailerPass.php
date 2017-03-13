<?php

namespace CL\Bundle\MailerBundle\DependencyInjection\Compiler;

use CL\Mailer\Driver\SwiftmailerDriver;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class DefaultMailerPass implements CompilerPassInterface
{
    /**
     * @inheritdoc
     */
    public function process(ContainerBuilder $container)
    {
        $driver = $container->getParameter('cl_mailer_driver');

        if ($container->hasDefinition($driver)) {
            $serviceId = $driver;
        } else {
            $serviceId = sprintf('cl_mailer.driver.%s', $driver);

            switch ($driver) {
                case 'swiftmailer':
                    $class = SwiftmailerDriver::class;
                    $args = [new Reference('swiftmailer.mailer.default')];
                    break;
                default:
                    $class = $driver;
                    $args = [];
                    break;
            }

            $container->setDefinition($serviceId, new Definition($class, $args));
        }

        $args = $container->getDefinition('cl_mailer.mailer')->getArguments();
        $args[1] = new Reference($serviceId);
        $container->getDefinition('cl_mailer.mailer')->setArguments($args);
    }
}