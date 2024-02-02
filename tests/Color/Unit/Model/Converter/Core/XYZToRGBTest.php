<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Model\Converter\Core;


use AlecRabbit\Color\Model\Contract\Converter\Core\ICoreConverter;
use AlecRabbit\Color\Model\Converter\Core\XYZToRGB;
use AlecRabbit\Color\Model\DTO\DHSL;
use AlecRabbit\Color\Model\DTO\DRGB;
use AlecRabbit\Color\Model\DTO\DXYZ;
use AlecRabbit\Color\Model\Exception\InvalidArgument;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class XYZToRGBTest extends TestCase
{
    public static function canConvertXYZToRGBDataProvider(): iterable
    {
        yield from [
            // [expected, incoming]
            [new DRGB(0, 0, 0), new DXYZ(0, 0, 0)],
            [new DRGB(0.749017, 0.800023, 0.639174), new DXYZ(0.496883, 0.569062, 0.430096)],
            [new DRGB(0.729425,0.368705,0.27059), new DXYZ(0.253287, 0.188771, 0.079388)],
            [new DRGB(0.290145,0.968619,0.799935), new DXYZ(0.469782, 0.723315, 0.686005)],
            [new DRGB(0.549031,0.372587,0.211765), new DXYZ(0.155743, 0.140275, 0.053766)],
            [new DRGB(0.319185,1.0,0.0), new DXYZ(0.5, 1, 0)],
            [new DRGB(0.202318,0.0,0.0), new DXYZ(-0.5, -1, -0.234520)],
            [new DRGB(0.0,0.0,0.0), new DXYZ(-1, -1, -0.6)],
            [new DRGB(0.329339,0.44314,0.999913, 0.2424), new DXYZ(0.276051, 0.209124, 0.971701, 0.2424)],
            [new DRGB(0.709818,0.368698,0.262747), new DXYZ(0.240739, 0.182371, 0.075614)],
            [new DRGB(0.294097,0.403927,0.588184), new DXYZ(0.132551, 0.133975, 0.307357)],
            [new DRGB(0.960804, 1, 0.02789), new DXYZ(0.734573, 0.909497, 0.138865)],
        ];
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $converter = $this->getTesteeInstance();

        self::assertInstanceOf(XYZToRGB::class, $converter);
    }

    protected function getTesteeInstance(
        ?int $precision = null,
    ): ICoreConverter {
        return new XYZToRGB(
            precision: $precision ?? ICoreConverter::CALC_PRECISION,
        );
    }

    #[Test]
    #[DataProvider('canConvertXYZToRGBDataProvider')]
    public function canConvertXYZToRGB(DRGB $expected, DXYZ $incoming): void
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
            'Color must be instance of "AlecRabbit\Color\Model\DTO\DXYZ", "AlecRabbit\Color\Model\DTO\DHSL" given.'
        );

        $testee = $this->getTesteeInstance();

        $testee->convert($input);
    }
}
