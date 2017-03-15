<?php

declare(strict_types=1);

namespace CL\Bundle\MailerBundle;

use CL\Bundle\MailerBundle\DependencyInjection\Compiler\MailerDriverPass;
use CL\Bundle\MailerBundle\DependencyInjection\Compiler\RegisterMailerTypesPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class CLMailerBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new RegisterMailerTypesPass());
        $container->addCompilerPass(new MailerDriverPass());
    }
}
