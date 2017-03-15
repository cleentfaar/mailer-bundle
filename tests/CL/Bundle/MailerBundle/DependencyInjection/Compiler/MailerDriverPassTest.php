<?php

declare(strict_types=1);

namespace CL\Bundle\MailerBundle\Tests\DependencyInjection\Compiler;

use CL\Bundle\MailerBundle\DependencyInjection\CLMailerExtension;
use CL\Bundle\MailerBundle\DependencyInjection\Compiler\MailerDriverPass;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractCompilerPassTestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class MailerDriverPassTest extends AbstractCompilerPassTestCase
{
    /**
     * @const string
     */
    const DRIVER_CLASS = 'Acme\FoobarDriver';

    /**
     * @const string
     */
    const DRIVER_SERVICE_ID = 'my_driver';

    /**
     * @const string
     */
    const MAILER_ID = 'my_mailer';

    /**
     * @test
     */
    public function the_compiler_will_assign_the_driver_class_to_the_mailer_as_second_argument()
    {
        $this->setDefinition(MailerDriverPass::MAILER_SERVICE_ID, new Definition(null, [0 => 'first argument']));
        $this->setParameter(CLMailerExtension::MAILER_DRIVER_PARAMETER, self::DRIVER_CLASS);

        $this->compile();

        $arguments = $this->container->getDefinition(MailerDriverPass::MAILER_SERVICE_ID)->getArguments();
        $driverReference = $arguments[1];

        parent::assertSame(self::DRIVER_CLASS, $this->container->getDefinition($driverReference)->getClass());
    }

    /**
     * @test
     */
    public function the_compiler_will_assign_the_driver_service_to_the_mailer_as_second_argument()
    {
        $this->setParameter(CLMailerExtension::MAILER_DRIVER_PARAMETER, self::DRIVER_SERVICE_ID);
        $this->setDefinition(MailerDriverPass::MAILER_SERVICE_ID, new Definition(null, [0 => 'first argument']));
        $this->setDefinition(self::DRIVER_SERVICE_ID, new Definition());

        $this->compile();

        $arguments = $this->container->getDefinition(MailerDriverPass::MAILER_SERVICE_ID)->getArguments();
        $driverReference = $arguments[1];

        parent::assertInstanceOf(Reference::class, $driverReference);
        parent::assertSame(self::DRIVER_SERVICE_ID, (string) $driverReference);
    }

    /**
     * @inheritdoc
     */
    protected function registerCompilerPass(ContainerBuilder $container)
    {
        $container->addCompilerPass(new MailerDriverPass());
    }
}
