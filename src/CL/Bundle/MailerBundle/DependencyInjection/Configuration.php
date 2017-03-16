<?php

namespace CL\Bundle\MailerBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * @inheritdoc
     */
    public function getConfigTreeBuilder()
    {
        $defaultDriver = class_exists('CL\Mailer\Driver\SwiftmailerDriver') ? 'cl_mailer.driver.swiftmailer' : null;
        $builder = new TreeBuilder();

        $builder->root('cl_mailer')
            ->children()
                ->scalarNode('driver')
                    ->defaultValue($defaultDriver)
                ->end()
            ->end()
        ;

        return $builder;
    }
}
