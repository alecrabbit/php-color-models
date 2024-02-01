<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Converter\A;

use AlecRabbit\Color\Model\Contract\Converter\Core\IDCoreConverter;
use AlecRabbit\Color\Model\Contract\Converter\IModelConverter;
use AlecRabbit\Color\Model\Contract\DTO\DColor;
use AlecRabbit\Color\Model\Contract\IColorModel;

abstract readonly class AModelConverter implements IModelConverter
{
    /** @var class-string<DColor> */
    protected string $inputType;
    protected IDCoreConverter $converter;

    public function __construct(string $type = null, IDCoreConverter $converter = null)
    {
        /** @var null|class-string<DColor> $type */
        $this->inputType = $type ?? static::from()->dtoType();
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

    protected static function createConverter(): IDCoreConverter
    {
        return new (static::getConverterClass())();
    }

    /**
     * @return class-string<IDCoreConverter>
     */
    abstract protected static function getConverterClass(): string;

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
