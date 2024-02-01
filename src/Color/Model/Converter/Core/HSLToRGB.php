<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Converter\Core;

use AlecRabbit\Color\Model\Contract\DTO\DColor;
use AlecRabbit\Color\Model\Converter\Core\A\ACoreConverter;
use AlecRabbit\Color\Model\DTO\DHSL as HSL;
use AlecRabbit\Color\Model\DTO\DRGB as RGB;

final readonly class HSLToRGB extends ACoreConverter
{
    public function __construct(int $precision = self::CALC_PRECISION)
    {
        parent::__construct(HSL::class, $precision);
    }

    protected function doConvert(DColor $color): DColor
    {
        /** @var HSL $color */
        $c = (1 - abs(2 * $color->lightness - 1)) * $color->saturation;
        $x = $c * (1 - abs(fmod($color->hue * 6, 2) - 1));
        $m = $color->lightness - $c / 2;

        $r = 0;
        $g = 0;
        $b = 0;

        match (true) {
            $color->hue < 1 / 6 => [$r, $g] = [$c, $x],
            $color->hue < 2 / 6 => [$r, $g] = [$x, $c],
            $color->hue < 3 / 6 => [$g, $b] = [$c, $x],
            $color->hue < 4 / 6 => [$g, $b] = [$x, $c],
            $color->hue < 5 / 6 => [$r, $b] = [$x, $c],
            default => [$r, $b] = [$c, $x],
        };

        return
            new RGB(
                round(($r + $m), $this->precision),
                round(($g + $m), $this->precision),
                round(($b + $m), $this->precision),
                round($color->alpha, $this->precision),
            );
    }
}
