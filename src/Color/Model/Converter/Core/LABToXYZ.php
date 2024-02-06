<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Converter\Core;

use AlecRabbit\Color\Model\Contract\Converter\Core\IIlluminant;
use AlecRabbit\Color\Model\Contract\DTO\DColor;
use AlecRabbit\Color\Model\Converter\Core\A\ACoreConverter;
use AlecRabbit\Color\Model\Converter\Core\Illuminant\D65Deg2;
use AlecRabbit\Color\Model\DTO\DLAB as LAB;
use AlecRabbit\Color\Model\DTO\DXYZ as XYZ;

/** @internal */
final readonly class LABToXYZ extends ACoreConverter
{
    private const DELTA = 6.0 / 29.0;
    private const D3 = self::DELTA ** 3; // 0.008856
    private const C4 = 4.0 / 29.0;
    private const O3 = 1 / 3;
    private const D6 = self::O3 * (self::DELTA ** -2); // 7.787037
    private const C6 = 16 / 116;

    public function __construct(
        private IIlluminant $illuminant = new D65Deg2(),
        int $precision = self::CALC_PRECISION
    ) {
        parent::__construct(LAB::class, $precision);
    }

    protected function doConvert(DColor $color): DColor
    {
        /** @var LAB $color */
        $l = $this->normalizeL($color->l);
        $a = $this->normalizeA($color->a);
        $b = $this->normalizeB($color->b);

        $l_ = ($l + 16.0) / 116.0;

        $x = $this->f($l_ + $a / 500);
        $y = $this->f($l_);
        $z = $this->f($l_ - $b / 200);

        return new XYZ(
            round($this->illuminant->x * $x, $this->precision),
            round($this->illuminant->y * $y, $this->precision),
            round($this->illuminant->z * $z, $this->precision),
            round($color->alpha, $this->precision)
        );
    }

    private function normalizeL(float $l): float
    {
        return $l * 100;
    }

    private function normalizeA(float $a): float
    {
        return $a * 127;
    }

    private function normalizeB(float $b): float
    {
        return $b * 127;
    }

    protected function f(float $t): float
    {
        return $t > self::DELTA
            ? $t ** 3.0
            : ($t - self::C6) / self::D6;
    }
}
