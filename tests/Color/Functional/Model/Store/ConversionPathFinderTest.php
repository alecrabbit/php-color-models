<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Functional\Model\Store;

use AlecRabbit\Color\Model\Converter\CMYKToCMYModelConverter;
use AlecRabbit\Color\Model\Converter\CMYToCMYKModelConverter;
use AlecRabbit\Color\Model\Converter\CMYToRGBModelConverter;
use AlecRabbit\Color\Model\Converter\HSLToRGBModelConverter;
use AlecRabbit\Color\Model\Converter\RGBToCMYModelConverter;
use AlecRabbit\Color\Model\Converter\RGBToHSLModelConverter;
use AlecRabbit\Color\Model\ModelCMY;
use AlecRabbit\Color\Model\ModelHSL;
use AlecRabbit\Color\Model\ModelRGB;
use AlecRabbit\Color\Model\Store\ConversionPathFinder;
use AlecRabbit\Color\Model\Store\IConversionPathFinder;
use AlecRabbit\Tests\TestCase\TestCase;
use ArrayObject;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class ConversionPathFinderTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $finder = $this->getTesteeInstance();
        self::assertInstanceOf(ConversionPathFinder::class, $finder);
    }

    private function getTesteeInstance(
        ?\Traversable $modelConverters = null,
        ?ArrayObject $models = null,
        ?ArrayObject $graph = null,
    ): IConversionPathFinder {
        return new ConversionPathFinder(
            modelConverters: $modelConverters ?? $this->getTraversableMock(),
            models: $models ?? new ArrayObject(),
            graph: $graph ?? new ArrayObject(),
        );
    }

    private function getTraversableMock(): MockObject&\Traversable
    {
        return $this->createMock(\Traversable::class);
    }

    #[Test]
    public function canFindPath(): void
    {
        $expected = [
            0 => ModelHSL::class,
            1 => ModelRGB::class,
            2 => ModelCMY::class,
        ];

        $from = new ModelHSL();
        $to = new ModelCMY();

        $finder = $this->getTesteeInstance(
            modelConverters: $this->getModelConverters()
        );

        $path = $finder->findPath($from, $to);

        $actual = iterator_to_array($path); // unwrap generator

        self::assertCount(3, $actual);
        self::assertEquals($expected, $actual);
    }

    private function getModelConverters(): \ArrayObject
    {
        return new \ArrayObject([
            CMYKToCMYModelConverter::class,
            CMYToCMYKModelConverter::class,
            CMYToRGBModelConverter::class,
            HSLToRGBModelConverter::class,
            RGBToCMYModelConverter::class,
            RGBToHSLModelConverter::class,
        ]);
    }
}
