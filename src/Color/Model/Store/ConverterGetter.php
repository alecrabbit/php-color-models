<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Store;

use AlecRabbit\Color\Model\Contract\Converter\Builder\IConverterFactoryBuilder;
use AlecRabbit\Color\Model\Contract\Converter\Factory\IChainConverterFactory;
use AlecRabbit\Color\Model\Contract\Converter\IConverter;
use AlecRabbit\Color\Model\Contract\IColorModel;
use AlecRabbit\Color\Model\Contract\Store\IConverterGetter;
use AlecRabbit\Color\Model\Exception\UnsupportedModelConversion;
use Traversable;

final readonly class ConverterGetter implements IConverterGetter
{
    public function __construct(
        private Traversable $modelConverters,
        private IConverterFactoryBuilder $converterFactoryBuilder,
        private IConversionPathFinderBuilder $conversionPathFinderBuilder,
    ) {
    }

    public function get(IColorModel $from, IColorModel $to): IConverter
    {
        return $this->createConverter(
            $this->findConversionPath($from, $to)
        );
    }

    /**
     * @param Traversable<class-string<IColorModel>> $conversionPath
     *
     * @throws UnsupportedModelConversion
     */
    private function createConverter(Traversable $conversionPath): IConverter
    {
        return $this->getChainConverterFactory()->create($conversionPath);
    }

    private function getChainConverterFactory(): IChainConverterFactory
    {
        return $this->converterFactoryBuilder
            ->withConverters($this->modelConverters)
            ->build()
        ;
    }

    private function findConversionPath(IColorModel $from, IColorModel $to): \Traversable
    {
        return $this->getConversionPathFinder()->findPath($from, $to);
    }

    private function getConversionPathFinder(): IConversionPathFinder
    {
        return $this->conversionPathFinderBuilder
            ->withConverters($this->modelConverters)
            ->build();
    }
}
