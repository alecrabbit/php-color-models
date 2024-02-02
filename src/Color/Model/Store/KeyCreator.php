<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Store;

use AlecRabbit\Color\Model\Contract\Converter\IModelConverter;
use AlecRabbit\Color\Model\Contract\IColorModel;

final readonly class KeyCreator implements IKeyCreator
{
    public function __construct(
        private string $glue = '::',
    ) {
    }

    /**
     * @param class-string<IModelConverter> $class
     */
    public function create(string $class): string
    {
        return $this->extractFrom($class) . $this->glue . $this->extractTo($class);
    }

    /**
     * @param class-string<IModelConverter> $class
     * @return class-string<IColorModel>
     */
    public function extractFrom(string $class): string
    {
        return $class::from()::class;
    }

    /**
     * @param class-string<IModelConverter> $class
     * @return class-string<IColorModel>
     */
    public function extractTo(string $class): string
    {
        return $class::to()::class;
    }
}
