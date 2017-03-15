<?php

declare(strict_types=1);

namespace CL\Bundle\MailerBundle\DependencyInjection\Compiler;

use CL\Bundle\MailerBundle\DependencyInjection\CLMailerExtension;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class MailerDriverPass implements CompilerPassInterface
{
    const MAILER_SERVICE_ID = 'cl_mailer.mailer';

    /**
     * @inheritdoc
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition(self::MAILER_SERVICE_ID)) {
            return;
        }

        if (!$container->hasParameter(CLMailerExtension::MAILER_DRIVER_PARAMETER)) {
            return;
        }

        $driver = $container->getParameter(CLMailerExtension::MAILER_DRIVER_PARAMETER);

        if ($container->hasDefinition($driver)) {
            // service id supplied, can be used directly
            $serviceId = $driver;
        } else {
            // class (fqcn) supplied, must be converted into a service first
            $serviceId = sprintf('cl_mailer.driver.%s', str_replace('\\', '_', $driver));
            $definition = new Definition($driver);
            $definition->setPublic(false);

            $container->setDefinition($serviceId, $definition);
        }

        $mailerDefinition = $container->getDefinition(self::MAILER_SERVICE_ID);

        $this->assignDriverArgument($mailerDefinition, $serviceId);
    }

    /**
     * @param Definition $mailerDefinition
     * @param string     $driverServiceId
     */
    private function assignDriverArgument(Definition $mailerDefinition, string $driverServiceId)
    {
        $args = $mailerDefinition->getArguments();
        $args[1] = new Reference($driverServiceId);

        $mailerDefinition->setArguments($args);
    }
}
