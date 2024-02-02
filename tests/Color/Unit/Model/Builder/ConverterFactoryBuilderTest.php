<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Model\Builder;

use AlecRabbit\Color\Model\Builder\ConverterFactoryBuilder;
use AlecRabbit\Color\Model\Contract\Converter\Builder\IConverterFactoryBuilder;
use AlecRabbit\Color\Model\Converter\Factory\ChainConverterFactory;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class ConverterFactoryBuilderTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $builder = $this->getTesteeInstance();
        self::assertInstanceOf(ConverterFactoryBuilder::class, $builder);
    }

    private function getTesteeInstance(): IConverterFactoryBuilder
    {
        return new ConverterFactoryBuilder();
    }

    #[Test]
    public function canBuild(): void
    {
        $builder = $this->getTesteeInstance();

        $factory = $builder
            ->withConverters(new \ArrayObject())
            ->build()
        ;
        self::assertInstanceOf(ChainConverterFactory::class, $factory);
    }

    #[Test]
    public function throwsIfModelConvertersIsNotSet(): void
    {
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Model converters are not set.');

        $builder = $this->getTesteeInstance();
        $builder->build();

        self::fail('Exception was not thrown.');
    }
}
