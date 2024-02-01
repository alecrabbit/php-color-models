<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Contract;

use AlecRabbit\Color\Model\Contract\DTO\DColor;

interface IColorModel
{
    /**
     * @return class-string<DColor>
     */
    public function dtoType(): string;
}
