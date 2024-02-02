<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Builder;

use AlecRabbit\Builder\Dummy\Dummy;
use AlecRabbit\Builder\Dummy\IDummy;
use AlecRabbit\Color\Model\Store\ConversionPathFinder;
use AlecRabbit\Color\Model\Store\IConversionPathFinder;
use AlecRabbit\Color\Model\Store\IConversionPathFinderBuilder;
use Traversable;

final class ConversionPathFinderBuilder implements IConversionPathFinderBuilder
{
    public function __construct(
        private Traversable|IDummy $modelConverters = new Dummy(),
    ) {
    }


    public function build(): IConversionPathFinder
    {
        if ($this->modelConverters instanceof IDummy) {
            throw new \LogicException('Model converters are not set.');
        }

        return new ConversionPathFinder($this->modelConverters);
    }

    /**
     * @inheritDoc
     */
    public function withConverters(Traversable $converters): IConversionPathFinderBuilder
    {
        $clone = clone $this;
        $clone->modelConverters = $converters;
        return $clone;
    }
}
