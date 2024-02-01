<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Model\Converter\Core;


use AlecRabbit\Color\Model\Contract\Converter\Core\IDCoreConverter;
use AlecRabbit\Color\Model\Converter\Core\CMYToCMYK;
use AlecRabbit\Color\Model\DTO\DCMY;
use AlecRabbit\Color\Model\DTO\DCMYK;
use AlecRabbit\Color\Model\DTO\DHSL;
use AlecRabbit\Color\Model\Exception\InvalidArgument;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class CMYToCMYKTest extends TestCase
{
    public static function canConvertCMYToCMYKDataProvider(): iterable
    {
        yield from [
            // [expected, incoming]
            [new DCMYK(0, 0, 0, 0), new DCMY(0, 0, 0)],
            [new DCMYK(0, 0, 0, 1), new DCMY(1.0, 1.0, 1.0)],
            [new DCMYK(0.0881, 0, 0.72619, 0.16), new DCMY(0.234, 0.160, 0.77)],
            [new DCMYK(0.11273, 0, 0.76505, 0.136), new DCMY(0.2334, 0.1360, 0.797)],
            [new DCMYK(0.39535, 0.29767, 0.0, 0.57), new DCMY(0.74, 0.698, 0.57)],
            [new DCMYK(0.0, 0.6406, 0.49526, 0.62769), new DCMY(0.62769, 0.86619, 0.81208)],
        ];
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $converter = $this->getTesteeInstance();

        self::assertInstanceOf(CMYToCMYK::class, $converter);
    }

    protected function getTesteeInstance(
        ?int $precision = null,
    ): IDCoreConverter {
        return new CMYToCMYK(
            precision: $precision ?? 5,
        );
    }

    #[Test]
    #[DataProvider('canConvertCMYToCMYKDataProvider')]
    public function canConvertCMYToCMYK(DCMYK $expected, DCMY $incoming): void
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
            'Color must be instance of "AlecRabbit\Color\Model\DTO\DCMY", "AlecRabbit\Color\Model\DTO\DHSL" given.'
        );

        $testee = $this->getTesteeInstance();

        $testee->convert($input);
    }
}
