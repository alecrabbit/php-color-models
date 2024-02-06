<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Converter\Core;

use AlecRabbit\Color\Model\Contract\DTO\DColor;
use AlecRabbit\Color\Model\Converter\Core\A\ACoreConverter;
use AlecRabbit\Color\Model\DTO\DRGB as RGB;
use AlecRabbit\Color\Model\DTO\DXYZ as XYZ;

/** @internal */
final readonly class RGBToXYZ extends ACoreConverter
{
    public function __construct(int $precision = self::CALC_PRECISION)
    {
        parent::__construct(RGB::class, $precision);
    }

    /**
     *  Resulting XYZ values correspond to the D65Deg2 illuminant.
     */
    protected function doConvert(DColor $color): DColor
    {
        /** @var RGB $color */
        $r = $this->gammaCorrection($color->r);
        $g = $this->gammaCorrection($color->g);
        $b = $this->gammaCorrection($color->b);

        $x = $r * 0.4124564 + $g * 0.3575761 + $b * 0.1804375;
        $y = $r * 0.2126729 + $g * 0.7151522 + $b * 0.0721750;
        $z = $r * 0.0193339 + $g * 0.1191920 + $b * 0.9503041;

        return new XYZ(
            round($x, $this->precision),
            round($y, $this->precision),
            round($z, $this->precision),
            round($color->alpha, $this->precision)
        );
    }

    protected function gammaCorrection(float $v): float
    {
        return $v > 0.04045 ? (($v + 0.055) / 1.055) ** 2.4 : $v / 12.92;
    }
}
