<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Model\Model\Converter\Core\Normalizer;

use AlecRabbit\Color\Model\Contract\Converter\Core\IIlluminant;
use AlecRabbit\Color\Model\Contract\Converter\Core\IXYZNormalizer;
use AlecRabbit\Color\Model\Converter\Core\Illuminant\D65Deg2;
use AlecRabbit\Color\Model\Converter\Core\Normalizer\XYZNormalizer;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class XYZNormalizerTest extends TestCase
{
    public static function normalizeValuesDataProvider(): iterable
    {
        yield from [
            [0.55124, 0.55124, 1.0],
            [0.34729, 0.34729, 1.0],
            [0.91638, 0.91638, 1.0],
            [1.83276, 0.91638, 2.0],
        ];
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $normalizer = $this->getTesteeInstance();

        self::assertInstanceOf(XYZNormalizer::class, $normalizer);
    }

    private function getTesteeInstance(
        IIlluminant $illuminant = new D65Deg2(),
    ): IXYZNormalizer {
        return new XYZNormalizer(
            illuminant: $illuminant,
        );
    }

    #[Test]
    #[DataProvider('normalizeValuesDataProvider')]
    public function canDenormalizeX(float $result, float $in, float $mul): void
    {
        $illuminant = $this->getIlluminantMock();
        $illuminant
            ->expects(self::once())
            ->method('referenceX')
            ->willReturn($mul)
        ;

        $normalizer = $this->getTesteeInstance($illuminant);

        self::assertEqualsWithDelta(
            $result,
            $normalizer->normalizeX($in),
            self::FLOAT_EQUALITY_DELTA
        );
    }

    private function getIlluminantMock(): MockObject&IIlluminant
    {
        return $this->createMock(IIlluminant::class);
    }

    #[Test]
    #[DataProvider('normalizeValuesDataProvider')]
    public function canDenormalizeY(float $result, float $in, float $mul): void
    {
        $illuminant = $this->getIlluminantMock();
        $illuminant
            ->expects(self::once())
            ->method('referenceY')
            ->willReturn($mul)
        ;

        $normalizer = $this->getTesteeInstance($illuminant);

        self::assertEqualsWithDelta(
            $result,
            $normalizer->normalizeY($in),
            self::FLOAT_EQUALITY_DELTA
        );
    }

    #[Test]
    #[DataProvider('normalizeValuesDataProvider')]
    public function canDenormalizeZ(float $result, float $in, float $mul): void
    {
        $illuminant = $this->getIlluminantMock();
        $illuminant
            ->expects(self::once())
            ->method('referenceZ')
            ->willReturn($mul)
        ;

        $normalizer = $this->getTesteeInstance($illuminant);
        self::assertEqualsWithDelta(
            $result,
            $normalizer->normalizeZ($in),
            self::FLOAT_EQUALITY_DELTA
        );
    }
}
