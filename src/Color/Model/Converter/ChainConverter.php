<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Converter;

use AlecRabbit\Color\Model\Contract\Converter\IChainConverter;
use AlecRabbit\Color\Model\Contract\Converter\IDColorConverter;
use AlecRabbit\Color\Model\Contract\DTO\DColor;

/**
 * @internal
 * @codeCoverageIgnore
 */
final readonly class ChainConverter implements IChainConverter
{
    /** @param iterable<class-string<IDColorConverter>> $chain */
    public function __construct(
        private iterable $chain,
    ) {
    }

    public function convert(DColor $color): DColor
    {
        /** @var class-string<IDColorConverter> $converter */
        foreach ($this->chain as $converter) {
            $color = (new $converter())->convert($color);
        }

        return $color;
    }
}
