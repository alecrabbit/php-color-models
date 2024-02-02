<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Model\Store;

use AlecRabbit\Color\Model\Store\ConversionPathFinder;
use AlecRabbit\Color\Model\Store\IConversionPathFinder;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class ConversionPathFinderTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $finder = $this->getTesteeInstance();
        self::assertInstanceOf(ConversionPathFinder::class, $finder);
    }

    private function getTesteeInstance(): IConversionPathFinder
    {
        return new ConversionPathFinder();
    }
}
