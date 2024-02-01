<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Converter\Core\A;

use AlecRabbit\Color\Model\Contract\Converter\Core\IDCoreConverter;
use AlecRabbit\Color\Model\Contract\DTO\DColor;
use AlecRabbit\Color\Model\Exception\InvalidArgument;

abstract readonly class ACoreConverter implements IDCoreConverter
{
    /** @var class-string<DColor> */
    protected string $inputType;

    /** @param class-string<DColor> $inputType */
    public function __construct(
        string $inputType,
        protected int $precision,
    ) {
        $this->inputType = $inputType;
    }

    public function convert(DColor $color): DColor
    {
        $this->assertColor($color);

        return $this->doConvert($color);
    }

    protected function assertColor(DColor $color): void
    {
        match (true) {
            is_a($color, $this->inputType, true) => null,
            default => throw new InvalidArgument(
                sprintf(
                    '%s: Color must be instance of "%s", "%s" given.',
                    static::class,
                    $this->inputType,
                    $color::class,
                ),
            ),
        };
    }

    abstract protected function doConvert(DColor $color): DColor;
}
