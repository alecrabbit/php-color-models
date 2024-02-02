<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Converter\Builder;

use AlecRabbit\Builder\Dummy\Dummy;
use AlecRabbit\Builder\Dummy\IDummy;
use AlecRabbit\Color\Model\Contract\Converter\Builder\IChainConverterBuilder;
use AlecRabbit\Color\Model\Contract\Converter\IChainConverter;
use AlecRabbit\Color\Model\Contract\Converter\IConverter;
use AlecRabbit\Color\Model\Contract\Converter\IModelConverter;
use AlecRabbit\Color\Model\Contract\IColorModel;
use AlecRabbit\Color\Model\Converter\ChainConverter;
use AlecRabbit\Color\Model\Exception\ConverterNotFound;
use ArrayObject;
use LogicException;
use Traversable;

use function is_subclass_of;

final class ChainConverterBuilder implements IChainConverterBuilder
{
    /** @var ArrayObject<string, class-string<IConverter>> */
    private readonly ArrayObject $convertersCache;

    /**
     * @param Traversable<class-string<IConverter>>|IDummy $converters
     * @param Traversable<class-string<IColorModel>>|IDummy $conversionPath
     */
    public function __construct(
        private Traversable|IDummy $converters = new Dummy(),
        private Traversable|IDummy $conversionPath = new Dummy(),
        ArrayObject $convertersCache = new ArrayObject(),
    ) {
        /** @var ArrayObject<string, class-string<IConverter>> $convertersCache */
        $this->convertersCache = $convertersCache;
    }

    public function build(): IChainConverter
    {
        $this->ensureConvertersCache();

        if ($this->conversionPath instanceof IDummy) {
            throw new LogicException('Path is not provided.');
        }

        return new ChainConverter(
            $this->getConvertersChain($this->conversionPath)
        );
    }

    private function ensureConvertersCache(): void
    {
        if ($this->converters instanceof IDummy) {
            throw new LogicException('Converters are not set.');
        }

        /** @var class-string<IConverter> $converter */
        foreach ($this->converters as $converter) {
            if (is_subclass_of($converter, IModelConverter::class)) {
                $key = self::createKey($converter);
                $this->convertersCache->offsetSet($key, $converter);
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
     * @param Traversable<class-string<IColorModel>> $conversionPath
     *
     * @return Traversable<class-string<IConverter>>
     * @throws ConverterNotFound
     */
    private function getConvertersChain(Traversable $conversionPath): Traversable
    {
        $previous = null;
        foreach ($conversionPath as $current) {
            if ($previous === null) {
                $previous = $current;
                continue;
            }

            yield $this->getConverterClass($previous, $current);
            $previous = $current;
        }
    }

    /**
     * @param class-string<IColorModel> $previous
     * @param class-string<IColorModel> $current
     *
     * @return class-string<IConverter>
     * @throws ConverterNotFound
     */
    private function getConverterClass(string $previous, string $current): string
    {
        return $this->findConverterClass(self::concatKey($previous, $current))
            ??
            throw new ConverterNotFound(
                sprintf(
                    'Converter from "%s" to "%s" not found.',
                    $previous,
                    $current,
                )
            );
    }

    /**
     * @return null|class-string<IConverter>
     */
    private function findConverterClass(string $concatKey): ?string
    {
        return $this->convertersCache->offsetExists($concatKey)
            ? $this->convertersCache->offsetGet($concatKey)
            : null;
    }

    /** @inheritDoc */
    public function withPath(Traversable $conversionPath): IChainConverterBuilder
    {
        $clone = clone $this;
        $clone->conversionPath = $conversionPath;
        return $clone;
    }

    /** @inheritDoc */
    public function withConverters(iterable $converters): IChainConverterBuilder
    {
        $clone = clone $this;
        $clone->converters = $converters;
        return $clone;
    }
}
