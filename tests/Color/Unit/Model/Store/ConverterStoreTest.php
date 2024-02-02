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

    private function getTesteeInstance(): IConverterStore
    {
        return new ConverterStore();
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

    protected function getChainConverterBuilderMock(): MockObject&IChainConverterBuilder
    {
        return $this->createMock(IChainConverterBuilder::class);
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
