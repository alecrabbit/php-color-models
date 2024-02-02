<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Builder;

use AlecRabbit\Builder\Dummy\Dummy;
use AlecRabbit\Builder\Dummy\IDummy;
use AlecRabbit\Color\Model\Contract\Converter\Builder\IConverterFactoryBuilder;
use AlecRabbit\Color\Model\Contract\Converter\Factory\IChainConverterFactory;
use AlecRabbit\Color\Model\Converter\Factory\ChainConverterFactory;
use Traversable;

final class ConverterFactoryBuilder implements IConverterFactoryBuilder
{
    public function __construct(
        private Traversable|IDummy $modelConverters = new Dummy(),
    ) {
    }

    public function build(): IChainConverterFactory
    {
        if ($this->modelConverters instanceof IDummy) {
            throw new \LogicException('Model converters are not set.');
        }

        return new ChainConverterFactory($this->modelConverters);
    }

    /**
     * @inheritDoc
     */
    public function withConverters(Traversable $converters): IConverterFactoryBuilder
    {
        $clone = clone $this;
        $clone->modelConverters = $converters;
        return $clone;
    }
}
