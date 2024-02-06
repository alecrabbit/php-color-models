<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Model\Model\Converter\Core\Normalizer;

use AlecRabbit\Color\Model\Contract\Converter\Core\IIlluminant;
use AlecRabbit\Color\Model\Contract\Converter\Core\IXYZDenormalizer;
use AlecRabbit\Color\Model\Contract\Converter\Core\ILABRange;
use AlecRabbit\Color\Model\Converter\Core\Illuminant\D65Deg2;
use AlecRabbit\Color\Model\Converter\Core\Normalizer\XYZDenormalizer;
use AlecRabbit\Color\Model\Converter\Core\Normalizer\LABRange;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class XYZDenormalizerTest extends TestCase
{
    public static function denormalizeValuesDataProvider(): iterable
    {
        yield from [
            [0.55124, 0.55124, 1.0],
            [0.34729, 0.34729, 1.0],
            [0.91638, 0.91638, 1.0],
            [0.45819, 0.91638, 2.0],
            [0.91638, 1.83276, 2.0],
        ];
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $denormalizer = $this->getTesteeInstance();

        self::assertInstanceOf(XYZDenormalizer::class, $denormalizer);
    }

    private function getTesteeInstance(
        IIlluminant $illuminant = new D65Deg2(),
    ): IXYZDenormalizer {
        return new XYZDenormalizer(
            illuminant: $illuminant,
        );
    }

    #[Test]
    #[DataProvider('denormalizeValuesDataProvider')]
    public function canDenormalizeX(float $result, float $in, float $mul): void
    {
        $illuminant = $this->getIlluminantMock();
        $illuminant
            ->expects(self::once())
            ->method('referenceX')
            ->willReturn($mul)
        ;

        $denormalizer = $this->getTesteeInstance($illuminant);

        self::assertEqualsWithDelta(
            $result,
            $denormalizer->denormalizeX($in),
            self::FLOAT_EQUALITY_DELTA
        );
    }

    private function getIlluminantMock(): MockObject&IIlluminant
    {
        return $this->createMock(IIlluminant::class);
    }

    #[Test]
    #[DataProvider('denormalizeValuesDataProvider')]
    public function canDenormalizeY(float $result, float $in, float $mul): void
    {
        $illuminant = $this->getIlluminantMock();
        $illuminant
            ->expects(self::once())
            ->method('referenceY')
            ->willReturn($mul)
        ;

        $denormalizer = $this->getTesteeInstance($illuminant);
        self::assertEqualsWithDelta(
            $result,
            $denormalizer->denormalizeY($in),
            self::FLOAT_EQUALITY_DELTA
        );
    }

    #[Test]
    #[DataProvider('denormalizeValuesDataProvider')]
    public function canDenormalizeZ(float $result, float $in, float $mul): void
    {
        $illuminant = $this->getIlluminantMock();
        $illuminant
            ->expects(self::once())
            ->method('referenceZ')
            ->willReturn($mul)
        ;

        $denormalizer = $this->getTesteeInstance($illuminant);
        self::assertEqualsWithDelta(
            $result,
            $denormalizer->denormalizeZ($in),
            self::FLOAT_EQUALITY_DELTA
        );
    }
}
