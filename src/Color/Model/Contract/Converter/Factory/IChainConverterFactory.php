<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Contract\Converter\Factory;

use AlecRabbit\Color\Model\Contract\Converter\IChainConverter;
use AlecRabbit\Color\Model\Exception\UnsupportedModelConversion;
use Traversable;

interface IChainConverterFactory
{
    /**
     * @throws UnsupportedModelConversion
     */
    public function create(Traversable $conversionPath): IChainConverter;
}
