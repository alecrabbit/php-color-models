<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Converter;

use AlecRabbit\Color\Model\Contract\Converter\IChainConverter;
use AlecRabbit\Color\Model\Contract\Converter\IConverter;
use AlecRabbit\Color\Model\Contract\DTO\DColor;
use AlecRabbit\Color\Model\Exception\InvalidArgument;

/**
 * @internal
 * @codeCoverageIgnore
 */
final readonly class ChainConverter implements IChainConverter
{
    /** @param iterable<class-string<IConverter>> $converters */
    public function __construct(
        private iterable $converters,
    ) {
    }

    private static function assertClass(string $class): void
    {
        if (!is_subclass_of($class, IConverter::class)) {
            throw new InvalidArgument(
                sprintf(
                    'Chain conversion failed. Invalid type "%s" provided. Converter class must implement "%s".',
                    $class,
                    IConverter::class,
                )
            );
        }
    }

    public function convert(DColor $color): DColor
    {
        /** @var class-string<IConverter> $converterClass */
        foreach ($this->converters as $converterClass) {
            self::assertClass($converterClass);
            $color = (new $converterClass())->convert($color);
        }

        return $color;
    }
}
