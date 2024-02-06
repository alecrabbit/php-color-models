<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Model\Converter\Core\Normalizer;

use AlecRabbit\Color\Model\Contract\Converter\Core\ILABRange;
use AlecRabbit\Color\Model\Converter\Core\Range\LABRange;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class LABRangeTest extends TestCase
{
    public static function canGetDataProvider(): iterable
    {
        yield from [
            [100.0, 127.0, 127.0],
            [1, 0.4, 0.4],
            [1, 1, 1],
            [100, 150, 150],
        ];
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $range = $this->getTesteeInstance();

        self::assertInstanceOf(LABRange::class, $range);
    }

    private function getTesteeInstance(
        ?float $maxL = null,
        ?float $maxA = null,
        ?float $maxB = null,
    ): ILABRange {
        return new LABRange(
            maxL: $maxL ?? 100.0,
            maxA: $maxA ?? 127.0,
            maxB: $maxB ?? 127.0,
        );
    }

    #[Test]
    #[DataProvider('canGetDataProvider')]
    public function canGet(float $maxL, float $maxA, float $maxB): void
    {
        $range = $this->getTesteeInstance(
            maxL: $maxL,
            maxA: $maxA,
            maxB: $maxB,
        );
        self::assertSame($maxL, $range->maxL());
        self::assertSame($maxA, $range->maxA());
        self::assertSame($maxB, $range->maxB());
        self::assertSame(0.0, $range->minL());
        self::assertSame(-$maxA, $range->minA());
        self::assertSame(-$maxB, $range->minB());
    }
}
