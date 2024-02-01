<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Contract\Converter\Builder;

use AlecRabbit\Color\Model\Contract\Converter\IChainConverter;
use AlecRabbit\Color\Model\Contract\Converter\IModelConverter;
use AlecRabbit\Color\Model\Contract\IColorModel;
use AlecRabbit\Color\Model\Exception\UnsupportedModelConversion;
use Traversable;

interface IChainConverterBuilder
{
    /**
     * @param Traversable<class-string<IColorModel>> $conversionPath
     *
     * @throws UnsupportedModelConversion
     */
    public function withPath(Traversable $conversionPath): IChainConverterBuilder;

    /**
     * @param Traversable<class-string<IModelConverter>> $converters
     */
    public function withConverters(Traversable $converters): IChainConverterBuilder;

    public function build(): IChainConverter;
}
