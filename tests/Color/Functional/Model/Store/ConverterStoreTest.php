<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Functional\Model\Store;


use AlecRabbit\Color\Model\Contract\Converter\Builder\IChainConverterBuilder;
use AlecRabbit\Color\Model\Contract\Store\IConverterStore;
use AlecRabbit\Color\Model\Converter\Builder\ChainConverterBuilder;
use AlecRabbit\Color\Model\Converter\CMYKToCMYModelConverter;
use AlecRabbit\Color\Model\Converter\CMYToCMYKModelConverter;
use AlecRabbit\Color\Model\Converter\CMYToRGBModelConverter;
use AlecRabbit\Color\Model\Converter\HSLToRGBModelConverter;
use AlecRabbit\Color\Model\Converter\RGBToCMYModelConverter;
use AlecRabbit\Color\Model\Converter\RGBToHSLModelConverter;
use AlecRabbit\Color\Model\DTO\DCMY;
use AlecRabbit\Color\Model\DTO\DHSL;
use AlecRabbit\Color\Model\ModelCMY;
use AlecRabbit\Color\Model\ModelHSL;
use AlecRabbit\Color\Model\Store\ConverterStore;
use AlecRabbit\Tests\TestCase\TestCase;
use ArrayObject;
use PHPUnit\Framework\Attributes\Test;

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
            chainConverterBuilder: $chainConverterBuilder ?? new ChainConverterBuilder(),
        );
    }

    #[Test]
    public function canGetConverter(): void
    {
        $store = $this->getTesteeInstance();

        $converter = $store->getConverter(new ModelHSL(), new ModelCMY());

        $color = new DHSL(0, 0, 0, 0);
        $actual = $converter->convert($color);

        self::assertEquals(new DCMY(1, 1, 1, 0), $actual);
    }

    protected function setUp(): void
    {
        parent::setUp();
        self::storeModelConvertersStorage();

        self::setModelConvertersStorage(self::getConvertersArray());
    }

    private static function storeModelConvertersStorage(): void
    {
        self::$modelConverters = self::extractModelConverters();
    }

    protected static function extractModelConverters(): array
    {
        return self::getPropertyValue(ConverterStore::class, self::MODEL_CONVERTERS);
    }

    private static function setModelConvertersStorage(mixed $value): void
    {
        self::setPropertyValue(ConverterStore::class, self::MODEL_CONVERTERS, $value);
    }

    private static function getConvertersArray(): array
    {
        return
            [
                CMYKToCMYModelConverter::class,
                CMYToCMYKModelConverter::class,
                CMYToRGBModelConverter::class,
                HSLToRGBModelConverter::class,
                RGBToCMYModelConverter::class,
                RGBToHSLModelConverter::class,
            ];
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
