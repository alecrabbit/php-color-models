<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Store;

use AlecRabbit\Color\Model\Contract\Converter\IModelConverter;
use AlecRabbit\Color\Model\Contract\IColorModel;

interface IKeyCreator
{
    /**
     * @param class-string<IModelConverter> $class
     */
    public function create(string $class): string;

    /**
     * @param class-string<IModelConverter> $class
     * @return class-string<IColorModel>
     */
    public function extractTo(string $class): string;

    /**
     * @param class-string<IModelConverter> $class
     * @return class-string<IColorModel>
     */
    public function extractFrom(string $class): string;
}
