<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Converter\Builder;

use AlecRabbit\Color\Model\Contract\Converter\Builder\IChainConverterBuilder;
use AlecRabbit\Color\Model\Contract\Converter\IChainConverter;
use AlecRabbit\Color\Model\Contract\Converter\IDColorConverter;
use AlecRabbit\Color\Model\Contract\Converter\IModelConverter;
use AlecRabbit\Color\Model\Contract\IColorModel;
use AlecRabbit\Color\Model\Converter\ChainConverter;
use AlecRabbit\Color\Model\Exception\UnsupportedModelConversion;
use LogicException;
use Traversable;

use function is_subclass_of;

final class ChainConverterBuilder implements IChainConverterBuilder
{
    /** @var iterable<class-string<IDColorConverter>> */
    private iterable $converters;

    /** @var iterable<class-string<IDColorConverter>> */
    private iterable $convertersCache;

    /** @var iterable<class-string<IDColorConverter>> */
    private iterable $chainConverters;

    public function build(): IChainConverter
    {
        $this->validate();

        return new ChainConverter($this->chainConverters);
    }

    private function validate(): void
    {
        match (true) {
            !isset($this->chainConverters) => throw new LogicException('Path is not provided.'),
            !isset($this->converters) => throw new LogicException('Converters are not set.'),
            default => null,
        };
    }

    /**
     * @inheritDoc
     */
    public function forPath(iterable $conversionPath): IChainConverterBuilder
    {
        $clone = clone $this;
        $clone->chainConverters = $this->getChainConvertersFromPath($conversionPath);
        return $clone;
    }

    /**
     * @param iterable<class-string<IColorModel>> $conversionPath
     *
     * @return Traversable<class-string<IDColorConverter>>
     * @throws UnsupportedModelConversion
     */
    private function getChainConvertersFromPath(iterable $conversionPath): Traversable
    {
        $prev = null;
        foreach ($conversionPath as $model) {
            if ($prev === null) {
                $prev = $model;
                continue;
            }

            yield $this->getConverterClass($prev, $model);
            $prev = $model;
        }
    }

    /**
     * @param class-string<IColorModel> $prev
     * @param class-string<IColorModel> $model
     *
     * @return class-string<IDColorConverter>
     * @throws UnsupportedModelConversion
     */
    private function getConverterClass(string $prev, string $model): string
    {
        $this->ensureConvertersCache();

        /**
         * @var string $key
         * @var class-string<IModelConverter> $converter
         */
        foreach ($this->convertersCache as $key => $converter) {
            if (self::concatKey($prev, $model) === $key) {
                return $converter;
            }
        }

        throw new UnsupportedModelConversion(
            sprintf(
                'Converter from "%s" to "%s" not found.',
                $prev,
                $model,
            )
        );
    }

    private function ensureConvertersCache(): void
    {
        if (!isset($this->convertersCache)) {
            $this->convertersCache = [];
            foreach ($this->converters as $converter) {
                if (is_subclass_of($converter, IModelConverter::class)) {
                    $this->convertersCache[self::createKey($converter)] = $converter;
                }
            }
        }
    }

    /**
     * @param class-string<IModelConverter> $converter
     */
    private static function createKey(string $converter): string
    {
        return self::concatKey($converter::from()::class, $converter::to()::class);
    }

    private static function concatKey(string $from, string $to): string
    {
        return $from . '::' . $to;
    }

    /**
     * @inheritDoc
     */
    public function withConverters(iterable $converters): IChainConverterBuilder
    {
        $clone = clone $this;
        $clone->converters = $converters;
        return $clone;
    }
}
