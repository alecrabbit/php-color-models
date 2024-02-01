<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Contract\Converter\Builder;

use AlecRabbit\Color\Model\Contract\Converter\IChainConverter;
use AlecRabbit\Color\Model\Contract\Converter\IModelConverter;
use AlecRabbit\Color\Model\Contract\IColorModel;
use AlecRabbit\Color\Model\Exception\UnsupportedModelConversion;

interface IChainConverterBuilder
{
    /**
     * @param \Traversable<class-string<IColorModel>> $conversionPath
     *
     * @throws UnsupportedModelConversion
     */
    public function forPath(\Traversable $conversionPath): IChainConverterBuilder;

    /**
     * @param \Traversable<class-string<IModelConverter>> $converters
     */
    public function withConverters(\Traversable $converters): IChainConverterBuilder;

    public function build(): IChainConverter;
}
