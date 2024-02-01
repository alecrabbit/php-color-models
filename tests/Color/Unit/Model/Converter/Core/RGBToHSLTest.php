<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Model\Converter\Core;


use AlecRabbit\Color\Model\Contract\Converter\Core\IDCoreConverter;
use AlecRabbit\Color\Model\Converter\Core\RGBToHSL;
use AlecRabbit\Color\Model\DTO\DHSL;
use AlecRabbit\Color\Model\DTO\DRGB;
use AlecRabbit\Color\Model\Exception\InvalidArgument;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class RGBToHSLTest extends TestCase
{
    public static function canConvertRGBToHSLDataProvider(): iterable
    {
        yield from [
            // [expected, incoming]
            [new DHSL(0, 0, 0), new DRGB(0, 0, 0)],
            [new DHSL(0.21952, 0.286713, 0.719608), new DRGB(0.749012, 0.8, 0.639216)],
            [new DHSL(0.458574, 0.915343, 0.629412), new DRGB(0.290196, 0.968627, 0.8)],
            [new DHSL(0.079457, 0.443299, 0.380393), new DRGB(0.54902, 0.372549, 0.211765)],
            [new DHSL(0.638402, 1, 0.664706), new DRGB(0.329412, 0.443137, 1)],
            [new DHSL(0.039474, 0.459678, 0.486275), new DRGB(0.709804, 0.368627, 0.262745)],
            [new DHSL(0.604444, 0.333333, 0.441177), new DRGB(0.294118, 0.403922, 0.588235)],
            [new DHSL(0.035612, 0.458824, 0.50), new DRGB(0.729412, 0.368627, 0.270588)],
            [new DHSL(0.036415, 0.944444, 0.494118), new DRGB(0.960784, 0.231373, 0.027451)],
        ];
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $converter = $this->getTesteeInstance();

        self::assertInstanceOf(RGBToHSL::class, $converter);
    }

    protected function getTesteeInstance(
        ?int $precision = null,
    ): IDCoreConverter {
        return new RGBToHSL(
            precision: $precision ?? IDCoreConverter::CALC_PRECISION,
        );
    }

    #[Test]
    #[DataProvider('canConvertRGBToHSLDataProvider')]
    public function canConvertRGBToHSL(DHSL $expected, DRGB $incoming): void
    {
        $converter = $this->getTesteeInstance();

        self::assertEquals($expected, $converter->convert($incoming));
    }

    #[Test]
    public function throwsIfModelIsNotCorrect(): void
    {
        $input = new DHSL(0, 0, 0);

        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage(
            'Color must be instance of "AlecRabbit\Color\Model\DTO\DRGB", "AlecRabbit\Color\Model\DTO\DHSL" given.'
        );

        $testee = $this->getTesteeInstance();

        $testee->convert($input);
    }
}
