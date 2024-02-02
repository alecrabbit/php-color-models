<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Model\Converter\Factory;


use AlecRabbit\Color\Model\Contract\Converter\Builder\IChainConverterBuilder;
use AlecRabbit\Color\Model\Contract\Converter\Factory\IChainConverterFactory;
use AlecRabbit\Color\Model\Contract\Converter\IChainConverter;
use AlecRabbit\Color\Model\Converter\Factory\ChainConverterFactory;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class ChainConverterFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $factory = $this->getTesteeInstance();
        self::assertInstanceOf(ChainConverterFactory::class, $factory);
    }

    private function getTesteeInstance(
        \Traversable $modelConverters = null,
        IChainConverterBuilder $chainConverterBuilder = null,
    ): IChainConverterFactory {
        return new ChainConverterFactory(
            modelConverters: $modelConverters ?? $this->getTraversableMock(),
            chainConverterBuilder: $chainConverterBuilder ?? $this->getChainConverterBuilderMock(),
        );
    }

    private function getTraversableMock(): MockObject&\Traversable
    {
        return $this->createMock(\Traversable::class);
    }

    private function getChainConverterBuilderMock(): MockObject&IChainConverterBuilder
    {
        return $this->createMock(IChainConverterBuilder::class);
    }

    #[Test]
    public function canCreate(): void
    {
        $modelConverters = $this->getTraversableMock();
        $chainConverterBuilder = $this->getChainConverterBuilderMock();
        $conversionPath = $this->getTraversableMock();
        $converter = $this->getChainConverterMock();

        $chainConverterBuilder
            ->expects(self::once())
            ->method('withConverters')
            ->with($modelConverters)
            ->willReturnSelf()
        ;
        $chainConverterBuilder
            ->expects(self::once())
            ->method('withPath')
            ->with($conversionPath)
            ->willReturnSelf()
        ;
        $chainConverterBuilder
            ->expects(self::once())
            ->method('build')
            ->willReturn($converter)
        ;

        $factory = $this->getTesteeInstance(
            modelConverters: $modelConverters,
            chainConverterBuilder: $chainConverterBuilder,
        );

        $actual = $factory->create($conversionPath);

        self::assertSame($converter, $actual);
    }

    private function getChainConverterMock(): MockObject&IChainConverter
    {
        return $this->createMock(IChainConverter::class);
    }
}
