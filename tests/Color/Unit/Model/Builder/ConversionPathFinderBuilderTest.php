<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Model\Builder;

use AlecRabbit\Color\Model\Builder\ConversionPathFinderBuilder;
use AlecRabbit\Color\Model\Store\ConversionPathFinder;
use AlecRabbit\Color\Model\Store\IConversionPathFinderBuilder;
use AlecRabbit\Tests\TestCase\TestCase;
use ArrayObject;
use LogicException;
use PHPUnit\Framework\Attributes\Test;

final class ConversionPathFinderBuilderTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $builder = $this->getTesteeInstance();
        self::assertInstanceOf(ConversionPathFinderBuilder::class, $builder);
    }

    private function getTesteeInstance(): IConversionPathFinderBuilder
    {
        return new ConversionPathFinderBuilder();
    }

    #[Test]
    public function canBuild(): void
    {
        $builder = $this->getTesteeInstance();

        $finder = $builder
            ->withConverters(new ArrayObject())
            ->build()
        ;
        self::assertInstanceOf(ConversionPathFinder::class, $finder);
    }

    #[Test]
    public function throwsIfModelConvertersIsNotSet(): void
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Model converters are not set.');

        $builder = $this->getTesteeInstance();
        $builder->build();

        self::fail('Exception was not thrown.');
    }
}
