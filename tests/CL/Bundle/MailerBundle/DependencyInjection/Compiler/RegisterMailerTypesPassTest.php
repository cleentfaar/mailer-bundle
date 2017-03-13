<?php

declare(strict_types=1);

namespace CL\Bundle\MailerBundle\Tests\DependencyInjection\Compiler;

use CL\Bundle\MailerBundle\DependencyInjection\Compiler\RegisterMailerTypesPass;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractCompilerPassTestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class RegisterMailerTypesPassTest extends AbstractCompilerPassTestCase
{
    /**
     * @const string
     */
    const SERVICE_ID = 'my_mailer_type';

    /**
     * @test
     */
    public function if_compiler_pass_collects_services_by_adding_method_calls_these_will_exist()
    {
        $collectingService = new Definition();
        $this->setDefinition(RegisterMailerTypesPass::REGISTRY_ID, $collectingService);

        $collectedService = new Definition();
        $collectedService->addTag(RegisterMailerTypesPass::TAG_NAME);
        $this->setDefinition(self::SERVICE_ID, $collectedService);

        $this->compile();

        $this->assertContainerBuilderHasServiceDefinitionWithMethodCall(
            RegisterMailerTypesPass::REGISTRY_ID,
            'register',
            [
                new Reference(self::SERVICE_ID),
            ]
        );
    }

    /**
     * @inheritdoc
     */
    protected function registerCompilerPass(ContainerBuilder $container)
    {
        $container->addCompilerPass(new RegisterMailerTypesPass());
    }
}
