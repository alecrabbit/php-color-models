<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Model\Model\Converter\Core\Normalizer;

use AlecRabbit\Color\Model\Contract\Converter\Core\ILABDenormalizer;
use AlecRabbit\Color\Model\Contract\Converter\Core\ILABRange;
use AlecRabbit\Color\Model\Converter\Core\Denormalizer\LABDenormalizer;
use AlecRabbit\Color\Model\Converter\Core\Range\LABRange;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class LABDenormalizerTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $denormalizer = $this->getTesteeInstance();

        self::assertInstanceOf(LABDenormalizer::class, $denormalizer);
    }

    private function getTesteeInstance(
        ILABRange $range = new LABRange(),
    ): ILABDenormalizer {
        return new LABDenormalizer(
            range: $range,
        );
    }

    #[Test]
    public function canDenormalizeL(): void
    {
        $l = 0.55124;
        $range = $this->getRangeMock();
        $range
            ->expects(self::once())
            ->method('maxL')
            ->willReturn(1.0)
        ;

        $denormalizer = $this->getTesteeInstance($range);
        self::assertSame($l, $denormalizer->denormalizeL($l));
    }

    private function getRangeMock(): MockObject&ILABRange
    {
        return $this->createMock(ILABRange::class);
    }

    #[Test]
    public function canDenormalizeA(): void
    {
        $a = 0.234234;
        $range = $this->getRangeMock();
        $range
            ->expects(self::once())
            ->method('maxA')
            ->willReturn(1.0)
        ;

        $denormalizer = $this->getTesteeInstance($range);
        self::assertSame($a, $denormalizer->denormalizeA($a));
    }

    #[Test]
    public function canDenormalizeB(): void
    {
        $b = 0.564684;
        $range = $this->getRangeMock();
        $range
            ->expects(self::once())
            ->method('maxB')
            ->willReturn(1.0)
        ;

        $denormalizer = $this->getTesteeInstance($range);
        self::assertSame($b, $denormalizer->denormalizeB($b));
    }
}
