<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Model\Converter\Core\Normalizer;

use AlecRabbit\Color\Model\Contract\Converter\Core\IXYZDenormalizer;
use AlecRabbit\Color\Model\Contract\Converter\Core\IXYZNormalizer;
use AlecRabbit\Color\Model\Converter\Core\Normalizer\IlluminantXYZNormalizer;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class IlluminantXYZNormalizerTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $normalizer = $this->getTesteeInstance();

        self::assertInstanceOf(IlluminantXYZNormalizer::class, $normalizer);
    }

    private function getTesteeInstance(
        ?IXYZDenormalizer $denormalizer = null,
        ?IXYZNormalizer $normalizer = null,
    ): IXYZNormalizer {
        return new IlluminantXYZNormalizer(
            denormalizer: $denormalizer ?? $this->getDenormalizerMock(),
            normalizer: $normalizer ?? $this->getNormalizerMock(),
        );
    }

    private function getDenormalizerMock(): MockObject&IXYZDenormalizer
    {
        return $this->createMock(IXYZDenormalizer::class);
    }

    private function getNormalizerMock(): MockObject&IXYZNormalizer
    {
        return $this->createMock(IXYZNormalizer::class);
    }

    #[Test]
    public function canNormalizeX(): void
    {
        $x = 0.55124;

        $denormalizer = $this->getDenormalizerMock();
        $denormalizer
            ->expects(self::once())
            ->method('denormalizeX')
            ->with($x)
            ->willReturn($x)
        ;

        $normalizer = $this->getNormalizerMock();
        $normalizer
            ->expects(self::once())
            ->method('normalizeX')
            ->with($x)
            ->willReturn($x)
        ;

        $testee = $this->getTesteeInstance(
            denormalizer: $denormalizer,
            normalizer: $normalizer,
        );

        self::assertSame($x, $testee->normalizeX($x));
    }

    #[Test]
    public function canNormalizeY(): void
    {
        $y = 0.34729;

        $denormalizer = $this->getDenormalizerMock();
        $denormalizer
            ->expects(self::once())
            ->method('denormalizeY')
            ->with($y)
            ->willReturn($y)
        ;

        $normalizer = $this->getNormalizerMock();
        $normalizer
            ->expects(self::once())
            ->method('normalizeY')
            ->with($y)
            ->willReturn($y)
        ;

        $testee = $this->getTesteeInstance(
            denormalizer: $denormalizer,
            normalizer: $normalizer,
        );

        self::assertSame($y, $testee->normalizeY($y));
    }

    #[Test]
    public function canNormalizeZ(): void
    {
        $z = 0.91638;

        $denormalizer = $this->getDenormalizerMock();
        $denormalizer
            ->expects(self::once())
            ->method('denormalizeZ')
            ->with($z)
            ->willReturn($z)
        ;

        $normalizer = $this->getNormalizerMock();
        $normalizer
            ->expects(self::once())
            ->method('normalizeZ')
            ->with($z)
            ->willReturn($z)
        ;

        $testee = $this->getTesteeInstance(
            denormalizer: $denormalizer,
            normalizer: $normalizer,
        );

        self::assertSame($z, $testee->normalizeZ($z));
    }
}
