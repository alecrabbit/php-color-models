<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\A;

use AlecRabbit\Color\Model\Contract\DTO\DColor;
use AlecRabbit\Color\Model\Contract\IColorModel;

abstract class AColorModel implements IColorModel
{
    /** @param class-string<DColor> $dtoType */
    public function __construct(
        protected string $dtoType,
    ) {
    }

    public function dtoType(): string
    {
        return $this->dtoType;
    }
}
