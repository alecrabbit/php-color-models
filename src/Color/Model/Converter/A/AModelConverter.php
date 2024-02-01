<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Converter\A;

use AlecRabbit\Color\Model\Contract\Converter\Core\ICoreConverter;
use AlecRabbit\Color\Model\Contract\Converter\IModelConverter;
use AlecRabbit\Color\Model\Contract\DTO\DColor;
use AlecRabbit\Color\Model\Contract\IColorModel;

abstract readonly class AModelConverter implements IModelConverter
{
    protected ICoreConverter $converter;

    public function __construct( ICoreConverter $converter = null)
    {
        /** @var null|class-string<DColor> $dtoType */
        $this->converter = $converter ?? static::createConverter();
    }

    public static function from(): IColorModel
    {
        return new (static::getSourceModelClass())();
    }

    /**
     * @return class-string<IColorModel>
     */
    abstract protected static function getSourceModelClass(): string;

    protected static function createConverter(): ICoreConverter
    {
        return new (static::getCoreConverterClass())();
    }

    /**
     * @return class-string<ICoreConverter>
     */
    abstract protected static function getCoreConverterClass(): string;

    public static function to(): IColorModel
    {
        return new (static::getTargetModelClass())();
    }

    /**
     * @return class-string<IColorModel>
     */
    abstract protected static function getTargetModelClass(): string;

    public function convert(DColor $color): DColor
    {
        return $this->converter->convert($color);
    }
}
