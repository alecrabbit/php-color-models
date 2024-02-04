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
    private const COEFFICIENT = 4.0 / 29.0;

    public function __construct(
        private IIlluminant $illuminant = new D65(),
        int $precision = self::CALC_PRECISION
    ) {
        parent::__construct(XYZ::class, $precision);
    }

    protected function doConvert(DColor $color): DColor
    {
        /** @var XYZ $color */
        // Normalize XYZ values
        $x = $color->x / $this->illuminant->x;
        $y = $color->y / $this->illuminant->y;
        $z = $color->z / $this->illuminant->z;

        // Calculate LAB values
        $x = ($x > 0.008856) ? $x ** (1 / 3) : (7.787 * $x * 100 + 16 / 116) / 100;
        $y = ($y > 0.008856) ? $y ** (1 / 3) : (7.787 * $y * 100 + 16 / 116) / 100;
        $z = ($z > 0.008856) ? $z ** (1 / 3) : (7.787 * $z * 100 + 16 / 116) / 100;

        $l = max(0, 116 * $y * 100 - 16) / 100;
        $a = 10 * ($x - $y);
        $b = 4 * ($y - $z);

        return new LAB(
            round($l, $this->precision),
            round($a, $this->precision),
            round($b, $this->precision),
            round($color->alpha, $this->precision)
        );
    }

    protected function correction(float $v): float
    {
        return $v > self::DELTA
            ? $v ** 3.0
            : 3.0 * ($v - self::COEFFICIENT) * self::DELTA * self::DELTA;
    }

}
