<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Converter\Factory;

use AlecRabbit\Color\Model\Contract\Converter\Builder\IChainConverterBuilder;
use AlecRabbit\Color\Model\Contract\Converter\Factory\IChainConverterFactory;
use AlecRabbit\Color\Model\Contract\Converter\IChainConverter;
use AlecRabbit\Color\Model\Converter\Builder\ChainConverterBuilder;
use Traversable;

final readonly class ChainConverterFactory implements IChainConverterFactory
{
    public function __construct(
        private Traversable $modelConverters,
        private IChainConverterBuilder $chainConverterBuilder = new ChainConverterBuilder(),
    ) {
    }

    public function create(Traversable $conversionPath): IChainConverter
    {
        return $this->chainConverterBuilder
            ->withConverters($this->modelConverters)
            ->withPath($conversionPath)
            ->build()
        ;
    }
}
