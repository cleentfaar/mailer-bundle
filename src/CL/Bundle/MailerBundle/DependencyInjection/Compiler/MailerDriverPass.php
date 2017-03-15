<?php

declare(strict_types=1);

namespace CL\Bundle\MailerBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class MailerDriverPass implements CompilerPassInterface
{
    /**
     * @inheritdoc
     */
    public function process(ContainerBuilder $container)
    {
        if (!$driver = $container->getParameter('cl_mailer_driver')) {
            return;
        }

        if ($container->hasDefinition($driver)) {
            // service id supplied, can be used directly
            $serviceId = $driver;
        } else {
            // class supplied, must be converted into a service first
            $serviceId = sprintf('cl_mailer.driver.%s', $driver);

            $definition = $this->resolveDriverDefinition($driver);

            $container->setDefinition($serviceId, $definition);
        }

        $mailerDefinition = $container->getDefinition('cl_mailer.mailer');

        $this->assignDriverArgument($mailerDefinition, $serviceId);
    }

    /**
     * @param string $driver
     *
     * @return Definition
     */
    private function resolveDriverDefinition(string $driver): Definition
    {
        switch ($driver) {
            default:
                $class = $driver;
                $args = [];
                break;
        }

        return new Definition($class, $args);
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
