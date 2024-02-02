<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Store;

use AlecRabbit\Color\Model\Contract\Converter\IModelConverter;
use Traversable;

interface IConversionPathFinderBuilder
{
    public function build(): IConversionPathFinder;

    /**
     * @param Traversable<class-string<IModelConverter>> $converters
     */
    public function withConverters(Traversable $converters): IConversionPathFinderBuilder;
}
