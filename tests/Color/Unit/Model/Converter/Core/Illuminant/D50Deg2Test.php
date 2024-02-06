<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Model\Converter\Core\Illuminant;

use AlecRabbit\Color\Model\Contract\Converter\Core\IIlluminant;
use AlecRabbit\Color\Model\Converter\Core\Illuminant\D50Deg2;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;


final class D50Deg2Test extends TestCase
{
    private const DEFAULT_XN = 0.111;
    private const DEFAULT_YN = 0.222;
    private const DEFAULT_ZN = 0.333;

    #[Test]
    public function canReference(): void
    {
        $illuminant = $this->getTesteeInstance();

        self::assertInstanceOf(D50Deg2::class, $illuminant);

        $this->assertEqualsWithDelta(
            self::DEFAULT_XN,
            $illuminant->referenceX(),
            self::FLOAT_EQUALITY_DELTA
        );

        $this->assertEqualsWithDelta(
            self::DEFAULT_YN,
            $illuminant->referenceY(),
            self::FLOAT_EQUALITY_DELTA
        );

        $this->assertEqualsWithDelta(
            self::DEFAULT_ZN,
            $illuminant->referenceZ(),
            self::FLOAT_EQUALITY_DELTA
        );
    }

    protected function getTesteeInstance(
        ?float $x = null,
        ?float $y = null,
        ?float $z = null,
    ): IIlluminant {
        return new D50Deg2(
            x: $x ?? self::DEFAULT_XN,
            y: $y ?? self::DEFAULT_YN,
            z: $z ?? self::DEFAULT_ZN,
        );
    }
}
