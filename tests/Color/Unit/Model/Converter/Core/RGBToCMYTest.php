<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Model\Converter\Core;


use AlecRabbit\Color\Model\Contract\Converter\Core\IDCoreConverter;
use AlecRabbit\Color\Model\Converter\Core\RGBToCMY;
use AlecRabbit\Color\Model\DTO\DCMY;
use AlecRabbit\Color\Model\DTO\DHSL;
use AlecRabbit\Color\Model\DTO\DRGB;
use AlecRabbit\Color\Model\Exception\InvalidArgument;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class RGBToCMYTest extends TestCase
{
    public static function canConvertRGBToCMYDataProvider(): iterable
    {
        yield from [
            // [expected, incoming]
            [new DCMY(0, 0, 0), new DRGB(1, 1, 1, 1)],
            [new DCMY(1.0, 1.0, 1.0), new DRGB(0, 0, 0, 1)],
            [new DCMY(0.234, 0.160, 0.77, 0.16), new DRGB(0.766, 0.84, 0.23, 0.16)],
        ];
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $converter = $this->getTesteeInstance();

        self::assertInstanceOf(RGBToCMY::class, $converter);
    }

    protected function getTesteeInstance(
        ?int $precision = null,
    ): IDCoreConverter {
        return new RGBToCMY(
            precision: $precision ?? 5,
        );
    }

    #[Test]
    #[DataProvider('canConvertRGBToCMYDataProvider')]
    public function canConvertRGBToCMY(DCMY $expected, DRGB $incoming): void
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
