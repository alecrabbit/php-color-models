<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Functional\Model\Converter;

use AlecRabbit\Color\Model\Contract\Converter\IChainConverter;
use AlecRabbit\Color\Model\Contract\DTO\DColor;
use AlecRabbit\Color\Model\Converter\ChainConverter;
use AlecRabbit\Color\Model\Converter\HSLToRGBModelConverter;
use AlecRabbit\Color\Model\Converter\LABToXYZModelConverter;
use AlecRabbit\Color\Model\Converter\RGBToCMYModelConverter;
use AlecRabbit\Color\Model\Converter\RGBToHSLModelConverter;
use AlecRabbit\Color\Model\Converter\RGBToXYZModelConverter;
use AlecRabbit\Color\Model\Converter\XYZToLABModelConverter;
use AlecRabbit\Color\Model\Converter\XYZToRGBModelConverter;
use AlecRabbit\Color\Model\DTO\DCMY;
use AlecRabbit\Color\Model\DTO\DHSL;
use AlecRabbit\Color\Model\DTO\DLAB;
use AlecRabbit\Color\Model\DTO\DRGB;
use AlecRabbit\Color\Model\Exception\InvalidArgument;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class ChainConverterTest extends TestCase
{
    public static function canConvertDataProvider(): iterable
    {
        yield from [
            [new DRGB(0, 0, 0), new DRGB(0, 0, 0), []],
            [new DRGB(0, 0, 0), new DHSL(0, 0, 0), [HSLToRGBModelConverter::class]],
            [new DHSL(0, 0, 0), new DRGB(0, 0, 0), [RGBToHSLModelConverter::class]],
            [
                new DHSL(0, 0, 0),
                new DLAB(0, 0, 0),
                [
                    LABToXYZModelConverter::class,
                    XYZToRGBModelConverter::class,
                    RGBToHSLModelConverter::class,
                ]
            ],
            [
                new DLAB(0, 0, 0),
                new DHSL(0, 0, 0),
                [
                    HSLToRGBModelConverter::class,
                    RGBToXYZModelConverter::class,
                    XYZToLABModelConverter::class,
                ]
            ],
            [
                new DCMY(1, 1, 1),
                new DLAB(0, 0, 0),
                [
                    LABToXYZModelConverter::class,
                    XYZToRGBModelConverter::class,
                    RGBToCMYModelConverter::class,
                ]
            ],
        ];
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $converter = $this->getTesteeInstance();

        self::assertInstanceOf(ChainConverter::class, $converter);
    }

    private function getTesteeInstance(
        null|iterable $converters = null,
    ): IChainConverter {
        return new ChainConverter(
            converters: $converters ?? [],
        );
    }

    #[Test]
    #[DataProvider('canConvertDataProvider')]
    public function canConvert(DColor $expected, DColor $input, iterable $chain): void
    {
        $converter = $this->getTesteeInstance(
            converters: $chain,
        );

        $actual = $converter->convert($input);

        self::assertEquals($expected, $actual);
    }

    #[Test]
    public function throwsIfInvalidTypeProvided(): void
    {
        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage(
            'Chain conversion failed.'
            . ' Invalid type "AlecRabbit\Color\Model\Contract\DTO\DColor" provided.'
            . ' Converter class must implement "AlecRabbit\Color\Model\Contract\Converter\IConverter".'
        );

        $converter = $this->getTesteeInstance(
            converters: [DColor::class],
        );

        $converter->convert(new DRGB(0, 0, 0));
    }
}
