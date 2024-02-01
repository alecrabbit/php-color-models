<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Functional\Model\Builder;

use AlecRabbit\Color\Model\Contract\Converter\Builder\IChainConverterBuilder;
use AlecRabbit\Color\Model\Converter\Builder\ChainConverterBuilder;
use AlecRabbit\Color\Model\Converter\CMYKToCMYModelConverter;
use AlecRabbit\Color\Model\Converter\CMYToCMYKModelConverter;
use AlecRabbit\Color\Model\Converter\CMYToRGBModelConverter;
use AlecRabbit\Color\Model\Converter\HSLToRGBModelConverter;
use AlecRabbit\Color\Model\Converter\RGBToCMYModelConverter;
use AlecRabbit\Color\Model\Converter\RGBToHSLModelConverter;
use AlecRabbit\Color\Model\DTO\DCMY;
use AlecRabbit\Color\Model\DTO\DHSL;
use AlecRabbit\Color\Model\DTO\DRGB;
use AlecRabbit\Color\Model\Exception\UnsupportedModelConversion;
use AlecRabbit\Color\Model\ModelCMY;
use AlecRabbit\Color\Model\ModelHSL;
use AlecRabbit\Color\Model\ModelRGB;
use AlecRabbit\Tests\TestCase\TestCase;
use ArrayObject;
use LogicException;
use PHPUnit\Framework\Attributes\Test;
use Traversable;

final class ChainConverterBuilderTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $builder = $this->getTesteeInstance();

        self::assertInstanceOf(ChainConverterBuilder::class, $builder);
    }

    private function getTesteeInstance(): IChainConverterBuilder
    {
        return new ChainConverterBuilder();
    }

    #[Test]
    public function canBuildConverterEmptyPath(): void
    {
        $builder = $this->getTesteeInstance();

        $converter = $builder
            ->withConverters(new ArrayObject())
            ->withPath(new ArrayObject())
            ->build()
        ;

        self::assertInstanceOf(ChainConverterBuilder::class, $builder);

        $color = new DRGB(0, 0, 0);
        self::assertSame($color, $converter->convert($color));
    }

    #[Test]
    public function canBuild(): void
    {
        $builder = $this->getTesteeInstance();

        $conversionPath = new ArrayObject([
            ModelHSL::class,
            ModelRGB::class,
            ModelCMY::class,
        ]);

        $converter = $builder
            ->withConverters($this->getModelConverters())
            ->withPath($conversionPath)
            ->build()
        ;

        self::assertInstanceOf(ChainConverterBuilder::class, $builder);

        $color = new DHSL(0, 0, 0);

        $actual = $converter->convert($color);

        self::assertInstanceOf(DCMY::class, $actual);
        self::assertEquals(new DCMY(1, 1, 1, 1), $actual);
    }

    private function getModelConverters(): Traversable
    {
        return new ArrayObject(
            [
                CMYKToCMYModelConverter::class,
                CMYToCMYKModelConverter::class,
                CMYToRGBModelConverter::class,
                HSLToRGBModelConverter::class,
                RGBToCMYModelConverter::class,
                RGBToHSLModelConverter::class,
            ],
        );
    }

    #[Test]
    public function throwsIfConverterNotFoundForProvidedPath(): void
    {
        $this->expectException(UnsupportedModelConversion::class);
        $this->expectExceptionMessage(
            'Converter from "AlecRabbit\Color\Model\ModelHSL" to "AlecRabbit\Color\Model\ModelCMY" not found.'
        );

        $builder = $this->getTesteeInstance();

        $conversionPath = new ArrayObject([
            ModelHSL::class,
            ModelCMY::class,
        ]);

        $converter = $builder
            ->withConverters($this->getModelConverters())
            ->withPath($conversionPath)
            ->build()
        ;

        self::assertInstanceOf(ChainConverterBuilder::class, $builder);

        $color = new DHSL(0, 0, 0);

        $actual = $converter->convert($color);

        self::assertInstanceOf(DCMY::class, $actual);
        self::assertEquals(new DCMY(1, 1, 1, 1), $actual);
    }

    #[Test]
    public function throwsIfConvertersAreNotSet(): void
    {
        $builder = $this->getTesteeInstance();

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Converters are not set.');

        $builder
            ->withPath(new ArrayObject())
            ->build()
        ;

        self::fail('Exception was not thrown.');
    }

    #[Test]
    public function throwsIfPathIsNotProvidedSet(): void
    {
        $builder = $this->getTesteeInstance();

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Path is not provided.');

        $builder
            ->withConverters(new ArrayObject())
            ->build()
        ;
    }

}
