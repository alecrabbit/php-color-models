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
    public function __construct(
        private IIlluminant $illuminant = new D65(),
        int $precision = self::CALC_PRECISION
    ) {
        parent::__construct(XYZ::class, $precision);
    }

    protected function doConvert(DColor $color): DColor
    {
        /** @var XYZ $color */
        $x = ($color->x * 100) / ($this->illuminant->x * 100);
        $y = ($color->y * 100) / ($this->illuminant->y * 100);
        $z = ($color->z * 100) / ($this->illuminant->z * 100);

        $x = $this->correction($x);
        $y = $this->correction($y);
        $z = $this->correction($z);

        $l = max(0, 116 * $y - 16);
        $a = 5 * ($x - $y);
        $b = 2 * ($y - $z);

        return new LAB(
            round($l / 100, $this->precision),
            round($a , $this->precision),
            round($b, $this->precision),
            round($color->alpha, $this->precision)
        );
    }

    protected function correction(float $x): int|float
    {
        return ($x > 0.008856) ? $x ** (1 / 3) : (7.787 * $x + 16 / 116);
    }
}
