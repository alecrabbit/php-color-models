<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Converter;

use AlecRabbit\Color\Model\Contract\Converter\IChainConverter;
use AlecRabbit\Color\Model\Contract\Converter\IConverter;
use AlecRabbit\Color\Model\Contract\DTO\DColor;

/**
 * @internal
 * @codeCoverageIgnore
 */
final readonly class ChainConverter implements IChainConverter
{
    /** @param iterable<class-string<IConverter>> $converterChain */
    public function __construct(
        private iterable $converterChain,
    ) {
    }

    public function convert(DColor $color): DColor
    {
        /** @var class-string<IConverter> $converter */
        foreach ($this->converterChain as $converter) {
            $color = (new $converter())->convert($color);
        }

        return $color;
    }
}
