<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Converter\Core;

use AlecRabbit\Color\Model\Contract\Converter\Core\IIlluminant;
use AlecRabbit\Color\Model\Contract\Converter\Core\ILABDenormalizer;
use AlecRabbit\Color\Model\Contract\Converter\Core\IXYZDenormalizer;
use AlecRabbit\Color\Model\Contract\DTO\DColor;
use AlecRabbit\Color\Model\Converter\Core\A\ACoreConverter;
use AlecRabbit\Color\Model\Converter\Core\Illuminant\D65Deg2;
use AlecRabbit\Color\Model\Converter\Core\Normalizer\LABDenormalizer;
use AlecRabbit\Color\Model\Converter\Core\Normalizer\XYZDenormalizer;
use AlecRabbit\Color\Model\DTO\DLAB as LAB;
use AlecRabbit\Color\Model\DTO\DXYZ as XYZ;

/**
 * @internal
 *
 * Has related constants, search by [445e847e-f57e-48b5-b9b7-0ee1282ae7cd]
 */
final readonly class XYZToLAB extends ACoreConverter
{
    private const DELTA = 6.0 / 29.0;
    private const D3 = self::DELTA ** 3;
    private const O3 = 1 / 3;
    private const D6 = self::O3 * (self::DELTA ** -2);
    private const C6 = 16 / 116;

    public function __construct(
        private IXYZDenormalizer $xyz = new XYZDenormalizer(),
        private ILABDenormalizer $lab = new LABDenormalizer(),
        int $precision = self::CALC_PRECISION
    ) {
        parent::__construct(XYZ::class, $precision);
    }

    protected function doConvert(DColor $color): DColor
    {
        /** @var XYZ $color */
        $x = $this->f($this->xyz->denormalizeX($color->x));
        $y = $this->f($this->xyz->denormalizeY($color->y));
        $z = $this->f($this->xyz->denormalizeZ($color->z));

        $l = $this->lab->denormalizeL(116 * $y - 16);
        $a = $this->lab->denormalizeA(500 * ($x - $y));
        $b = $this->lab->denormalizeB(200 * ($y - $z));

        return new LAB(
            round($l, $this->precision),
            round($a, $this->precision),
            round($b, $this->precision),
            round($color->alpha, $this->precision)
        );
    }

    private function f(float $t): float
    {
        return $t > self::D3 ? $t ** self::O3 : self::D6 * $t + self::C6;
    }
}
