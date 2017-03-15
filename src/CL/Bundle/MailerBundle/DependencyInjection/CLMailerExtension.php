<?php

declare(strict_types=1);

namespace CL\Bundle\MailerBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

class CLMailerExtension extends Extension
{
    /**
     * @const string
     */
    const MAILER_DRIVER_PARAMETER = 'cl_mailer_driver';

    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $config = $this->processConfiguration(new Configuration(), $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $container->setParameter(self::MAILER_DRIVER_PARAMETER, $config['driver']);
    }
}
