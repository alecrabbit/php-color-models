<?php

declare(strict_types=1);

use AlecRabbit\Color\Model\Converter\CMYKToCMYModelConverter;
use AlecRabbit\Color\Model\Converter\CMYToCMYKModelConverter;
use AlecRabbit\Color\Model\Converter\CMYToRGBModelConverter;
use AlecRabbit\Color\Model\Converter\HSLToRGBModelConverter;
use AlecRabbit\Color\Model\Converter\LABToXYZModelConverter;
use AlecRabbit\Color\Model\Converter\RGBToCMYModelConverter;
use AlecRabbit\Color\Model\Converter\RGBToHSLModelConverter;
use AlecRabbit\Color\Model\Converter\RGBToXYZModelConverter;
use AlecRabbit\Color\Model\Converter\XYZToLABModelConverter;
use AlecRabbit\Color\Model\Converter\XYZToRGBModelConverter;
use AlecRabbit\Color\Model\Store\ConverterStore;

// @codeCoverageIgnoreStart

ConverterStore::add(
    CMYKToCMYModelConverter::class,
    CMYToCMYKModelConverter::class,
    CMYToRGBModelConverter::class,
    HSLToRGBModelConverter::class,
    RGBToCMYModelConverter::class,
    RGBToHSLModelConverter::class,
    RGBToXYZModelConverter::class,
    XYZToRGBModelConverter::class,
    LABToXYZModelConverter::class,
    XYZToLABModelConverter::class,
);

// @codeCoverageIgnoreEnd
