<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Model\Store;

use AlecRabbit\Color\Model\Contract\Converter\Builder\IConverterFactoryBuilder;
use AlecRabbit\Color\Model\Contract\Converter\Factory\IChainConverterFactory;
use AlecRabbit\Color\Model\Contract\Converter\IChainConverter;
use AlecRabbit\Color\Model\Contract\IColorModel;
use AlecRabbit\Color\Model\Contract\Store\IConverterGetter;
use AlecRabbit\Color\Model\Store\ConverterGetter;
use AlecRabbit\Color\Model\Store\IConversionPathFinder;
use AlecRabbit\Color\Model\Store\IConversionPathFinderBuilder;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class ConverterGetterTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $getter = $this->getTesteeInstance();
        self::assertInstanceOf(ConverterGetter::class, $getter);
    }

    private function getTesteeInstance(
        ?\Traversable $modelConverters = null,
        ?IConverterFactoryBuilder $chainConverterFactoryBuilder = null,
        ?IConversionPathFinderBuilder $conversionPathFinderBuilder = null,
    ): IConverterGetter {
        return new ConverterGetter(
            modelConverters: $modelConverters ?? $this->getTraversableMock(),
            converterFactoryBuilder: $chainConverterFactoryBuilder ?? $this->getConverterFactoryBuilderMock(),
            conversionPathFinderBuilder: $conversionPathFinderBuilder ?? $this->getConversionPathFinderBuilderMock(),
        );
    }

    private function getTraversableMock(): MockObject&\Traversable
    {
        return $this->createMock(\Traversable::class);
    }

    private function getConverterFactoryBuilderMock(): MockObject&IConverterFactoryBuilder
    {
        return $this->createMock(IConverterFactoryBuilder::class);
    }

    private function getConversionPathFinderBuilderMock(): MockObject&IConversionPathFinderBuilder
    {
        return $this->createMock(IConversionPathFinderBuilder::class);
    }

    #[Test]
    public function canGet(): void
    {
        $modelConverters = $this->getTraversableMock();
        $converterFactoryBuilder = $this->getConverterFactoryBuilderMock();
        $converterFactory = $this->getConverterFactoryMock();
        $conversionPathFinderBuilder = $this->getConversionPathFinderBuilderMock();
        $conversionPathFinder = $this->getConversionPathFinderMock();
        $from = $this->getColorModelMock();
        $to = $this->getColorModelMock();
        $conversionPath = $this->getTraversableMock();
        $converter = $this->getConverterMock();

        $getter = $this->getTesteeInstance(
            $modelConverters,
            $converterFactoryBuilder,
            $conversionPathFinderBuilder
        );

        $conversionPathFinderBuilder
            ->expects(self::once())
            ->method('withConverters')
            ->with($modelConverters)
            ->willReturnSelf()
        ;
        $conversionPathFinderBuilder
            ->expects(self::once())
            ->method('build')
            ->willReturn($conversionPathFinder)
        ;
        $converterFactory
            ->expects(self::once())
            ->method('create')
            ->with($conversionPath)
            ->willReturn($converter)
        ;

        $conversionPathFinder
            ->expects(self::once())
            ->method('findPath')
            ->with($from, $to)
            ->willReturn($conversionPath)
        ;

        $converterFactoryBuilder
            ->expects(self::once())
            ->method('withConverters')
            ->with($modelConverters)
            ->willReturnSelf()
        ;
        $converterFactoryBuilder
            ->expects(self::once())
            ->method('build')
            ->willReturn($converterFactory)
        ;

        $converterFactory
            ->expects(self::once())
            ->method('create')
            ->with($conversionPath)
            ->willReturn($converter)
        ;

        $actual = $getter->get($from, $to);

        self::assertSame($converter, $actual);
    }

    private function getConverterFactoryMock(): MockObject&IChainConverterFactory
    {
        return $this->createMock(IChainConverterFactory::class);
    }

    private function getConversionPathFinderMock(): MockObject&IConversionPathFinder
    {
        return $this->createMock(IConversionPathFinder::class);
    }

    private function getColorModelMock(): MockObject&IColorModel
    {
        return $this->createMock(IColorModel::class);
    }

    private function getConverterMock(): MockObject&IChainConverter
    {
        return $this->createMock(IChainConverter::class);
    }
}
