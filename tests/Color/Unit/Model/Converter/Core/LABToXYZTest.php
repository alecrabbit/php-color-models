<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Model\Converter\Core;


use AlecRabbit\Color\Model\Contract\Converter\Core\ICoreConverter;
use AlecRabbit\Color\Model\Converter\Core\LABToXYZ;
use AlecRabbit\Color\Model\DTO\DLAB;
use AlecRabbit\Color\Model\DTO\DXYZ;
use AlecRabbit\Color\Model\Exception\InvalidArgument;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class LABToXYZTest extends TestCase
{
    public static function canConvertLABToXYZDataProvider(): iterable
    {
        yield from [
            // [expected, incoming]
            [new DXYZ(0, 0, 0), new DLAB(0, 0, 0)],
            [new DXYZ(0.017674, 0, -0.044395), new DLAB(0, 0.5, 0.5)],
            [new DXYZ(-0.031003, 0, 0.502785), new DLAB(0, -1, -1)],
            [new DXYZ(1.874265, 1.0, 0.052947), new DLAB(1, 1, 1)],
            [new DXYZ(0.95047, 1.0, 1.08883), new DLAB(1, 0, 0)],
            [new DXYZ(0.394598, 1.0, 4.758974), new DLAB(1, -1, -1)],
            [new DXYZ(1.874265, 1.0, 4.758974), new DLAB(1, 1, -1)],
            [new DXYZ(0.394598, 1.0, 0.052947), new DLAB(1, -1, 1)],
        ];
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $converter = $this->getTesteeInstance();

        self::assertInstanceOf(LABToXYZ::class, $converter);
    }

    protected function getTesteeInstance(
        ?int $precision = null,
    ): ICoreConverter {
        return new LABToXYZ(
            precision: $precision ?? ICoreConverter::CALC_PRECISION,
        );
    }

    #[Test]
    #[DataProvider('canConvertLABToXYZDataProvider')]
    public function canConvertLABToXYZ(DXYZ $expected, DLAB $incoming): void
    {
        $converter = $this->getTesteeInstance();

        self::assertEquals($expected, $converter->convert($incoming));
    }

    #[Test]
    public function throwsIfModelIsNotCorrect(): void
    {
        $input = new DXYZ(0, 0, 0);

        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage(
            'Color must be instance of "AlecRabbit\Color\Model\DTO\DLAB", "AlecRabbit\Color\Model\DTO\DXYZ" given.'
        );

        $testee = $this->getTesteeInstance();

        $testee->convert($input);
    }
}
