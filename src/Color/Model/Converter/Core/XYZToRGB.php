<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Converter\Core;

use AlecRabbit\Color\Model\Contract\Converter\Core\IXYZNormalizer;
use AlecRabbit\Color\Model\Contract\DTO\DColor;
use AlecRabbit\Color\Model\Converter\Core\A\ACoreConverter;
use AlecRabbit\Color\Model\DTO\DRGB as RGB;
use AlecRabbit\Color\Model\DTO\DXYZ as XYZ;

/** @internal */
final readonly class XYZToRGB extends ACoreConverter
{
    private const C = 1 / 2.4;

    public function __construct(
        int $precision = self::CALC_PRECISION,
    )
    {
        parent::__construct(XYZ::class, $precision);
    }

    /**
     *  Input XYZ values should correspond to the D65Deg2 illuminant.
     */
    protected function doConvert(DColor $color): DColor
    {
        /** @var XYZ $color */
        $x = $color->x;
        $y = $color->y;
        $z = $color->z;

        $r = $x * 3.2406 + $y * -1.5372 + $z * -0.4986;
        $g = $x * -0.9689 + $y * 1.8758 + $z * 0.0415;
        $b = $x * 0.0557 + $y * -0.2040 + $z * 1.0570;

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
