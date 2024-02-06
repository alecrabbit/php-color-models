<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Converter\Core;

use AlecRabbit\Color\Model\Contract\Converter\Core\IIlluminant;
use AlecRabbit\Color\Model\Contract\DTO\DColor;
use AlecRabbit\Color\Model\Converter\Core\A\ACoreConverter;
use AlecRabbit\Color\Model\Converter\Core\Illuminant\D65;
use AlecRabbit\Color\Model\DTO\DLAB as LAB;
use AlecRabbit\Color\Model\DTO\DXYZ as XYZ;

/** @internal */
final readonly class XYZToLAB extends ACoreConverter
{
    private const DELTA = 6.0 / 29.0;
    private const D3 = self::DELTA ** 3;
    private const O3 = 1 / 3;
    private const D6 = self::O3 * (self::DELTA ** -2);
    private const C6 = 16 / 116;

    public function __construct(
        private IIlluminant $illuminant = new D65(),
        int $precision = self::CALC_PRECISION
    ) {
        parent::__construct(XYZ::class, $precision);
    }

    protected function doConvert(DColor $color): DColor
    {
        /** @var XYZ $color */
        $x = $this->f($color->x / $this->illuminant->x);
        $y = $this->f($color->y / $this->illuminant->y);
        $z = $this->f($color->z / $this->illuminant->z);

        $l = 116 * $y - 16;
        $a = 500 * ($x - $y);
        $b = 200 * ($y - $z);

        return new LAB(
            round($this->normalizeL($l), $this->precision),
            round($this->normalizeA($a), $this->precision),
            round($this->normalizeB($b), $this->precision),
            round($color->alpha, $this->precision)
        );
    }

    private function f(float $t): float
    {
        return $t > self::D3 ? $t ** self::O3 : self::D6 * $t + self::C6;
    }

    private function normalizeL(float $l): float
    {
        return max(0,$l / 100);
    }

    private function normalizeA(float $a): float
    {
        return $a / 127;
    }

    private function normalizeB(float $b): float
    {
        return $b / 127;
    }
}
