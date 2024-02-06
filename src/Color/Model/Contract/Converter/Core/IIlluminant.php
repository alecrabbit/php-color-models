<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Contract\Converter\Core;

/**
 * Marker interface.
 */
interface IIlluminant
{
    public function referenceX(): float;

    public function referenceY(): float;

    public function referenceZ(): float;

}
