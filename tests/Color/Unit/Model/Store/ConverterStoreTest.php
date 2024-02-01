<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Model\Store;


use AlecRabbit\Color\Model\Contract\Converter\Builder\IChainConverterBuilder;
use AlecRabbit\Color\Model\Contract\Store\IConverterStore;
use AlecRabbit\Color\Model\Exception\InvalidArgument;
use AlecRabbit\Color\Model\Store\ConverterStore;
use AlecRabbit\Tests\Color\Unit\Model\Converter\Override\ModelConverterOverrideOne;
use AlecRabbit\Tests\Color\Unit\Model\Converter\Override\ModelConverterOverrideOneOverride;
use AlecRabbit\Tests\Color\Unit\Model\Converter\Override\ModelConverterOverrideTwo;
use AlecRabbit\Tests\TestCase\TestCase;
use ArrayObject;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use stdClass;

final class ConverterStoreTest extends TestCase
{
    private const MODEL_CONVERTERS = 'modelConverters';
    private static array $modelConverters = [];

    #[Test]
    public function canBeInstantiated(): void
    {
        $store = $this->getTesteeInstance();

        self::assertInstanceOf(ConverterStore::class, $store);
    }

    private function getTesteeInstance(
        ?ArrayObject $models = null,
        ?ArrayObject $graph = null,
        ?IChainConverterBuilder $chainConverterBuilder = null
    ): IConverterStore {
        return new ConverterStore(
            models: $models ?? new ArrayObject(),
            graph: $graph ?? new ArrayObject(),
            chainConverterBuilder: $chainConverterBuilder ?? $this->getChainConverterBuilderMock(),
        );
    }

    protected function getChainConverterBuilderMock(): MockObject&IChainConverterBuilder
    {
        return $this->createMock(IChainConverterBuilder::class);
    }

    #[Test]
    public function canAdd(): void
    {
        $classOne = ModelConverterOverrideOne::class;
        $classTwo = ModelConverterOverrideTwo::class;

        ConverterStore::add($classOne);
        ConverterStore::add($classTwo);

        $modelConverters = self::getModelConverters();

        self::assertCount(2, $modelConverters);
        self::assertContains($classOne, $modelConverters);
        self::assertContains($classTwo, $modelConverters);
    }

    protected static function getModelConverters(): array
    {
        return self::getPropertyValue(ConverterStore::class, self::MODEL_CONVERTERS);
    }

    #[Test]
    public function modelsAreInitialized(): void
    {
        $classOne = ModelConverterOverrideOne::class;
        $classTwo = ModelConverterOverrideTwo::class;

        ConverterStore::add($classOne);
        ConverterStore::add($classTwo);

        $modelConverters = self::getModelConverters();

        self::assertCount(2, $modelConverters);
        self::assertContains($classOne, $modelConverters);
        self::assertContains($classTwo, $modelConverters);

        $models = new ArrayObject();
        $graph = new ArrayObject();

        $store = $this->getTesteeInstance(
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

        ConverterStore::add($classOne);
        ConverterStore::add($classTwo);

        $modelConverters = self::getModelConverters();

        self::assertCount(2, $modelConverters);
        self::assertContains($classOne, $modelConverters);
        self::assertContains($classTwo, $modelConverters);

        $models = new ArrayObject();
        $graph = new ArrayObject();

        $store = $this->getTesteeInstance(
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

    #[Test]
    public function canAddOverrideClass(): void
    {
        $classOne = ModelConverterOverrideOne::class;
        $classOneOverride = ModelConverterOverrideOneOverride::class;

        ConverterStore::add($classOne);

        $modelConverters = self::getModelConverters();

        self::assertCount(1, $modelConverters);
        self::assertContains($classOne, $modelConverters);

        ConverterStore::add($classOneOverride);

        $modelConverters = self::getModelConverters();

        self::assertCount(1, $modelConverters);
        self::assertContains($classOneOverride, $modelConverters);
    }

    #[Test]
    public function addingSameConverterClassTwiceDoesNotHaveEffect(): void
    {
        $class = ModelConverterOverrideOne::class;

        ConverterStore::add($class);
        ConverterStore::add($class);

        $modelConverters = self::getModelConverters();

        self::assertCount(1, $modelConverters);
        self::assertContains($class, $modelConverters);
    }

    #[Test]
    public function throwsIfAddedClassIsNotSubclassOfModelConverter(): void
    {
        $class = stdClass::class;

        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage(
            'Class "stdClass" is not subclass of "AlecRabbit\Color\Model\Contract\Converter\IModelConverter".'
        );

        ConverterStore::add($class);
    }

    protected function setUp(): void
    {
        parent::setUp();
        self::storeModelConvertersStorage();

        self::setModelConvertersStorage([]);
    }

    private static function storeModelConvertersStorage(): void
    {
        self::$modelConverters = self::getModelConverters();
    }

    private static function setModelConvertersStorage(mixed $value): void
    {
        self::setPropertyValue(ConverterStore::class, self::MODEL_CONVERTERS, $value);
    }

    protected function tearDown(): void
    {
        self::rollbackModelConvertersStorage();
        parent::tearDown();
    }

    private static function rollbackModelConvertersStorage(): void
    {
        self::setModelConvertersStorage(self::$modelConverters);
    }
}
