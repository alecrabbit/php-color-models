<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Model\Converter\Core;


use AlecRabbit\Color\Model\Contract\Converter\Core\ICoreConverter;
use AlecRabbit\Color\Model\Converter\Core\HSLToRGB;
use AlecRabbit\Color\Model\DTO\DHSL;
use AlecRabbit\Color\Model\DTO\DRGB;
use AlecRabbit\Color\Model\Exception\InvalidArgument;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class HSLtoRGBTest extends TestCase
{
    public static function canConvertHSLToRGBDataProvider(): iterable
    {
        yield from [
            // [expected, incoming]
            [new DRGB(0, 0, 0), new DHSL(0, 0, 0)],
            [new DRGB(0, 0, 0), new DHSL(0.033333, 0, 0)],
            [new DRGB(0.749774, 0.8012, 0.6388), new DHSL(0.219444, 0.29, 0.72)],
            [new DRGB(0.2896, 0.9704, 0.800199), new DHSL(0.458333, 0.92, 0.63)],
            [new DRGB(0.5472, 0.374428, 0.2128), new DHSL(0.080556, 0.44, 0.38)],
            [new DRGB(0.32, 0.433333, 1), new DHSL(0.638889, 1, 0.66)],
            [new DRGB(0.7154, 0.369787, 0.2646), new DHSL(0.038889, 0.46, 0.49)],
            [new DRGB(0.2948, 0.401279, 0.5852), new DHSL(0.605556, 0.33, 0.44)],
            [new DRGB(0.73, 0.369666, 0.27), new DHSL(0.036111, 0.46, 0.50)],
            [new DRGB(0.9506, 0.228993, 0.0294), new DHSL(0.036111, 0.94, 0.49)],
            [new DRGB(0.9595, 0.766049, 0.7405), new DHSL(0.019444, 0.73, 0.85)],
        ];
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $converter = $this->getTesteeInstance();

        self::assertInstanceOf(HSLToRGB::class, $converter);
    }

    protected function getTesteeInstance(
        ?int $precision = null,
    ): ICoreConverter {
        return new HSLToRGB(
            precision: $precision ?? ICoreConverter::CALC_PRECISION,
        );
    }

    #[Test]
    #[DataProvider('canConvertHSLToRGBDataProvider')]
    public function canConvertHSLToRGB(DRGB $expected, DHSL $incoming): void
    {
        $converter = $this->getTesteeInstance();

        self::assertEquals(
            $expected,
            $converter->convert($incoming)
        );
    }

    #[Test]
    public function throwsIfModelIsNotCorrect(): void
    {
        $input = new DRGB(0, 0, 0);

        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage(
            'Color must be instance of "AlecRabbit\Color\Model\DTO\DHSL", "AlecRabbit\Color\Model\DTO\DRGB" given.'
        );

        $testee = $this->getTesteeInstance();

        $testee->convert($input);
    }
}
