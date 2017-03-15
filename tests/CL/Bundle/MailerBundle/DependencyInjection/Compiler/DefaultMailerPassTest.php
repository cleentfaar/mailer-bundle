<?php

declare(strict_types=1);

namespace CL\Bundle\MailerBundle\Tests\DependencyInjection\Compiler;

use CL\Bundle\MailerBundle\DependencyInjection\Compiler\MailerDriverPass;
use CL\Bundle\MailerBundle\DependencyInjection\Compiler\RegisterMailerTypesPass;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractCompilerPassTestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class DefaultMailerPassTest extends AbstractCompilerPassTestCase
{
    const DRIVER_NAME = 'my_driver';
    /**
     * @const string
     */
    const MAILER_ID = 'my_mailer';

    /**
     * @test
     */
    public function the_compiler_will_assign_the_driver_service_to_the_mailer_as_second_argument()
    {
        $collectingService = new Definition();
        $this->setDefinition(RegisterMailerTypesPass::REGISTRY_ID, $collectingService);
        $this->setParameter('cl_mailer_driver', self::DRIVER_NAME);

        $mailerService = new Definition();
        $this->setDefinition(self::MAILER_ID, $mailerService);
        $expectedDriverDefinition = new Definition(self::DRIVER_NAME, []);

        $this->compile();

        $actualDriverDefinition = $this->container->getDefinition(self::MAILER_ID)->getArgument(1);

    }

    /**
     * @inheritdoc
     */
    protected function registerCompilerPass(ContainerBuilder $container)
    {
        $container->addCompilerPass(new MailerDriverPass());
    }
}
