<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Model\Store;

use AlecRabbit\Color\Model\Store\ConversionPathFinder;
use AlecRabbit\Color\Model\Store\IConversionPathFinder;
use AlecRabbit\Tests\Color\Unit\Model\Converter\Override\ModelConverterOverrideOne;
use AlecRabbit\Tests\Color\Unit\Model\Converter\Override\ModelConverterOverrideTwo;
use AlecRabbit\Tests\TestCase\TestCase;
use ArrayObject;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use Traversable;

final class ConversionPathFinderTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $finder = $this->getTesteeInstance();
        self::assertInstanceOf(ConversionPathFinder::class, $finder);
    }

    private function getTesteeInstance(
        ?Traversable $modelConverters = null,
        ?ArrayObject $models = null,
        ?ArrayObject $graph = null,
    ): IConversionPathFinder {
        return new ConversionPathFinder(
            modelConverters: $modelConverters ?? $this->getTraversableMock(),
            models: $models ?? $this->getArrayObjectMock(),
            graph: $graph ?? $this->getArrayObjectMock(),
        );
    }

    private function getTraversableMock(): MockObject&Traversable
    {
        return $this->createMock(Traversable::class);
    }

    private function getArrayObjectMock(): MockObject&ArrayObject
    {
        return $this->createMock(ArrayObject::class);
    }

    #[Test]
    public function modelsAreInitialized(): void
    {
        $classOne = ModelConverterOverrideOne::class;
        $classTwo = ModelConverterOverrideTwo::class;


        $modelConverters = [
            $classOne,
            $classTwo,
        ];

        self::assertCount(2, $modelConverters);
        self::assertContains($classOne, $modelConverters);
        self::assertContains($classTwo, $modelConverters);

        $models = new ArrayObject();
        $graph = new ArrayObject();

        $finder = $this->getTesteeInstance(
            modelConverters: new ArrayObject($modelConverters),
            models: $models,
            graph: $graph,
        );

        self::assertArrayHasKey($classOne::from()::class, $models);
        self::assertArrayHasKey($classOne::to()::class, $models);
        self::assertArrayHasKey($classTwo::from()::class, $models);
        self::assertArrayHasKey($classTwo::to()::class, $models);

        self::assertTrue($models[$classOne::from()::class]);
        self::assertTrue($models[$classOne::to()::class]);
        self::assertTrue($models[$classTwo::from()::class]);
        self::assertTrue($models[$classTwo::to()::class]);
    }

    #[Test]
    public function graphIsInitialized(): void
    {
        $classOne = ModelConverterOverrideOne::class;
        $classTwo = ModelConverterOverrideTwo::class;

        $modelConverters = [
            $classOne,
            $classTwo,
        ];

        self::assertCount(2, $modelConverters);
        self::assertContains($classOne, $modelConverters);
        self::assertContains($classTwo, $modelConverters);

        $models = new ArrayObject();
        $graph = new ArrayObject();

        $finder = $this->getTesteeInstance(
            modelConverters: new ArrayObject($modelConverters),
            models: $models,
            graph: $graph,
        );

        self::assertArrayHasKey($classOne::from()::class, $graph);
        self::assertArrayHasKey($classOne::to()::class, $graph);
        self::assertArrayHasKey($classTwo::from()::class, $graph);
        self::assertArrayHasKey($classTwo::to()::class, $graph);

        self::assertIsArray($graph[$classOne::from()::class]);
        self::assertIsArray($graph[$classOne::to()::class]);
        self::assertIsArray($graph[$classTwo::from()::class]);
        self::assertIsArray($graph[$classTwo::to()::class]);

        self::assertContains($classOne::to()::class, $graph[$classOne::from()::class]);
        self::assertNotContains($classOne::from()::class, $graph[$classOne::from()::class]);

        self::assertContains($classTwo::to()::class, $graph[$classTwo::from()::class]);
        self::assertNotContains($classTwo::from()::class, $graph[$classTwo::from()::class]);
    }
}
