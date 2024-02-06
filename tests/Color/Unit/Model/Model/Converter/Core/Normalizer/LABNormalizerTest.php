<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Model\Model\Converter\Core\Normalizer;

use AlecRabbit\Color\Model\Contract\Converter\Core\ILABNormalizer;
use AlecRabbit\Color\Model\Contract\Converter\Core\ILABRange;
use AlecRabbit\Color\Model\Converter\Core\Normalizer\LABNormalizer;
use AlecRabbit\Color\Model\Converter\Core\Normalizer\LABRange;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class LABNormalizerTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $normalizer = $this->getTesteeInstance();

        self::assertInstanceOf(LABNormalizer::class, $normalizer);
    }

    private function getTesteeInstance(
        ILABRange $range = new LABRange(),
    ): ILABNormalizer {
        return new LABNormalizer(
            range: $range,
        );
    }

    #[Test]
    public function canNormalizeL(): void
    {
        $l = 0.55124;
        $range = $this->getRangeMock();
        $range
            ->expects(self::once())
            ->method('maxL')
            ->willReturn(1.0)
        ;

        $normalizer = $this->getTesteeInstance($range);
        self::assertSame($l, $normalizer->normalizeL($l));
    }

    private function getRangeMock(): MockObject&ILABRange
    {
        return $this->createMock(ILABRange::class);
    }

    #[Test]
    public function canNormalizeA(): void
    {
        $a = 0.234234;
        $range = $this->getRangeMock();
        $range
            ->expects(self::once())
            ->method('maxA')
            ->willReturn(1.0)
        ;

        $normalizer = $this->getTesteeInstance($range);
        self::assertSame($a, $normalizer->normalizeA($a));
    }

    #[Test]
    public function canNormalizeB(): void
    {
        $b = 0.564684;
        $range = $this->getRangeMock();
        $range
            ->expects(self::once())
            ->method('maxB')
            ->willReturn(1.0)
        ;

        $normalizer = $this->getTesteeInstance($range);
        self::assertSame($b, $normalizer->normalizeB($b));
    }
}
