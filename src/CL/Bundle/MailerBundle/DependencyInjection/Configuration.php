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
        $builder = new TreeBuilder();

        $builder->root('cl_mailer')
            ->children()
                ->scalarNode('driver')
                    ->defaultValue(class_exists('CL\Mailer\Driver\SwiftmailerDriver') ? 'cl_mailer.driver.swiftmailer' : null)
                ->end()
            ->end()
        ;

        return $builder;
    }
}
