<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Converter\Core;

use AlecRabbit\Color\Model\Contract\DTO\DColor;
use AlecRabbit\Color\Model\Converter\Core\A\ACoreConverter;
use AlecRabbit\Color\Model\DTO\DXYZ as XYZ;
use AlecRabbit\Color\Model\DTO\DRGB as RGB;

/** @internal */
final readonly class XYZToRGB extends ACoreConverter
{
    private const C = 1 / 2.4;

    public function __construct(int $precision = self::CALC_PRECISION)
    {
        parent::__construct(XYZ::class, $precision);
    }

    protected function doConvert(DColor $color): DColor
    {
        /** @var XYZ $color */
        $r = $color->x * 3.2406 + $color->y * -1.5372 + $color->z * -0.4986;
        $g = $color->x * -0.9689 + $color->y * 1.8758 + $color->z * 0.0415;
        $b = $color->x * 0.0557 + $color->y * -0.2040 + $color->z * 1.0570;

        $r = $this->clip($this->gammaCorrection($r));
        $g = $this->clip($this->gammaCorrection($g));
        $b = $this->clip($this->gammaCorrection($b));

        return new RGB(
            round($r, $this->precision),
            round($g, $this->precision),
            round($b, $this->precision),
            round($color->alpha, $this->precision)
        );
    }

    private function clip(float $v): float
    {
        return min(1.0, max(0.0, $v));
    }

    private function gammaCorrection(float $v): float
    {
        return $v > 0.0031308 ? (1.055 * ($v ** self::C) - 0.055) : 12.92 * $v;
    }
}
