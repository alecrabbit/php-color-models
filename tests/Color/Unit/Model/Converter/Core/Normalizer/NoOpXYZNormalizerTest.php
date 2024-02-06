<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Model\Converter\Core\Normalizer;

use AlecRabbit\Color\Model\Contract\Converter\Core\IXYZDenormalizer;
use AlecRabbit\Color\Model\Contract\Converter\Core\IXYZNormalizer;
use AlecRabbit\Color\Model\Converter\Core\Normalizer\NoOpXYZNormalizer;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class NoOpXYZNormalizerTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $normalizer = $this->getTesteeInstance();

        self::assertInstanceOf(NoOpXYZNormalizer::class, $normalizer);
    }

    private function getTesteeInstance(
    ): IXYZNormalizer {
        return new NoOpXYZNormalizer(
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

        $testee = $this->getTesteeInstance();

        self::assertSame($x, $testee->normalizeX($x));
    }

    #[Test]
    public function canNormalizeY(): void
    {
        $y = 0.34729;

        $testee = $this->getTesteeInstance();

        self::assertSame($y, $testee->normalizeY($y));
    }

    #[Test]
    public function canNormalizeZ(): void
    {
        $z = 0.91638;

        $testee = $this->getTesteeInstance();
        self::assertSame($z, $testee->normalizeZ($z));
    }
}
