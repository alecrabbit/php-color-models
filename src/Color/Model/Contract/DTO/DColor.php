<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Contract\DTO;

/**
 * Marker interface.
 *
 * Implementations should follow the convention:
 *     - final readonly class
 *     - public properties
 *     - constructor with all properties as arguments
 *     - parameters representing values should be named accordingly to the color model
 *     - parameters should be of type float
 *     - values implied to be in range 0.0-1.0
 *     - alpha parameter should be optional with default value 1.0
 */
interface DColor
{

}
