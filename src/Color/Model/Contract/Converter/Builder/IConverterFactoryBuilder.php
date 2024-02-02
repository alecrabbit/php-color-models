<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Contract\Converter\Builder;

use AlecRabbit\Color\Model\Contract\Converter\Factory\IChainConverterFactory;
use AlecRabbit\Color\Model\Contract\Converter\IModelConverter;
use Traversable;

interface IConverterFactoryBuilder
{
    public function build(): IChainConverterFactory;

    /**
     * @param Traversable<class-string<IModelConverter>> $converters
     */
    public function withConverters(Traversable $converters): IConverterFactoryBuilder;

}
