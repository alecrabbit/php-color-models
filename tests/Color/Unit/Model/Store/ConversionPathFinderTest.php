<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Model\Store;

use AlecRabbit\Color\Model\Store\ConversionPathFinder;
use AlecRabbit\Color\Model\Store\IConversionPathFinder;
use AlecRabbit\Tests\TestCase\TestCase;
use ArrayObject;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class ConversionPathFinderTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $finder = $this->getTesteeInstance();
        self::assertInstanceOf(ConversionPathFinder::class, $finder);
    }

    private function getTesteeInstance(
        ?\Traversable $modelConverters = null,
        ?ArrayObject $models = null,
        ?ArrayObject $graph = null,
    ): IConversionPathFinder {
        return new ConversionPathFinder(
            modelConverters: $modelConverters ?? $this->getTraversableMock(),
            models: $models ?? $this->getArrayObjectMock(),
            graph: $graph ?? $this->getArrayObjectMock(),
        );
    }

    private function getTraversableMock(): MockObject&\Traversable
    {
        return $this->createMock(\Traversable::class);
    }

    private function getArrayObjectMock(): MockObject&ArrayObject
    {
        return $this->createMock(ArrayObject::class);
    }
}
