<?php

declare(strict_types=1);

namespace CL\Bundle\MailerBundle\Tests\DependencyInjection;

use CL\Bundle\MailerBundle\DependencyInjection\CLMailerExtension;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;

class CLMailerExtensionTest extends AbstractExtensionTestCase
{
    const DRIVER_NAME = 'my_driver';

    /**
     * @test
     */
    public function it_sets_the_correct_parameters_after_loading()
    {
        $this->load(['driver' => self::DRIVER_NAME]);

        $this->assertContainerBuilderHasParameter('cl_mailer_driver', self::DRIVER_NAME);
    }

    /**
     * @inheritdoc
     */
    protected function getContainerExtensions()
    {
        return [
            new CLMailerExtension(),
        ];
    }
}
