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
final readonly class LABToXYZ extends ACoreConverter
{
    private const DELTA = 6.0 / 29.0;
    private const COEFFICIENT = 4.0 / 29.0;

    public function __construct(
        private IIlluminant $illuminant = new D65(),
        int $precision = self::CALC_PRECISION
    ) {
        parent::__construct(LAB::class, $precision);
    }

    protected function doConvert(DColor $color): DColor
    {
        /** @var LAB $color */
        $l = ($color->l * 100 + 16.0) / 116.0;

        $x = $this->illuminant->x * $this->correction($l + $color->a / 10.0);
        $y = $this->illuminant->y * $this->correction($l);
        $z = $this->illuminant->z * $this->correction($l - $color->b / 4.0);

        return new XYZ(
            round($x, $this->precision),
            round($y, $this->precision),
            round($z, $this->precision),
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
