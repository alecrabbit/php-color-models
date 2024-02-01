<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Contract\Store;

use AlecRabbit\Color\Model\Contract\Converter\IDColorConverter;
use AlecRabbit\Color\Model\Contract\Converter\IModelConverter;
use AlecRabbit\Color\Model\Contract\IColorModel;
use AlecRabbit\Color\Model\Exception\UnsupportedModelConversion;

interface IConverterStore
{
    /**
     * @param class-string<IModelConverter> ...$classes
     */
    public static function add(string ...$classes): void;

    /**
     * @throws UnsupportedModelConversion
     */
    public function getColorConverter(IColorModel $from, IColorModel $to): IDColorConverter;
}
