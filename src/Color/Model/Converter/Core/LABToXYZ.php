<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Converter\Core;

use AlecRabbit\Color\Model\Contract\Converter\Core\IIlluminant;
use AlecRabbit\Color\Model\Contract\Converter\Core\ILABNormalizer;
use AlecRabbit\Color\Model\Contract\Converter\Core\IXYZNormalizer;
use AlecRabbit\Color\Model\Contract\DTO\DColor;
use AlecRabbit\Color\Model\Converter\Core\A\ACoreConverter;
use AlecRabbit\Color\Model\Converter\Core\Illuminant\D65Deg2;
use AlecRabbit\Color\Model\Converter\Core\Normalizer\LABNormalizer;
use AlecRabbit\Color\Model\Converter\Core\Normalizer\XYZNormalizer;
use AlecRabbit\Color\Model\DTO\DLAB as LAB;
use AlecRabbit\Color\Model\DTO\DXYZ as XYZ;

/**
 * @internal
 *
 * Has related constants, search by [445e847e-f57e-48b5-b9b7-0ee1282ae7cd]
 */
final readonly class LABToXYZ extends ACoreConverter
{
    private const DELTA = 6.0 / 29.0;
    private const O3 = 1 / 3;
    private const D6 = self::O3 * (self::DELTA ** -2);
    private const C6 = 16 / 116;

    public function __construct(
        private IXYZNormalizer $xyz = new XYZNormalizer(),
        private ILABNormalizer $lab = new LABNormalizer(),
        int $precision = self::CALC_PRECISION
    ) {
        parent::__construct(LAB::class, $precision);
    }

    protected function doConvert(DColor $color): DColor
    {
        /** @var LAB $color */
        $l = $this->lab->normalizeL($color->l);
        $a = $this->lab->normalizeA($color->a);
        $b = $this->lab->normalizeB($color->b);

        $l_ = ($l + 16.0) / 116.0;

        $x = $this->xyz->normalizeX($this->f($l_ + $a / 500));
        $y = $this->xyz->normalizeY($this->f($l_));
        $z = $this->xyz->normalizeZ($this->f($l_ - $b / 200));

        return new XYZ(
            round($x, $this->precision),
            round($y, $this->precision),
            round($z, $this->precision),
            round($color->alpha, $this->precision)
        );
    }

    protected function f(float $t): float
    {
        return $t > self::DELTA
            ? $t ** 3.0
            : ($t - self::C6) / self::D6;
    }
}
