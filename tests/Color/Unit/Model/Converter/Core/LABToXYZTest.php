<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Model\Converter\Core;


use AlecRabbit\Color\Model\Contract\Converter\Core\ICoreConverter;
use AlecRabbit\Color\Model\Converter\Core\LABToXYZ;
use AlecRabbit\Color\Model\DTO\DLAB;
use AlecRabbit\Color\Model\DTO\DXYZ;
use AlecRabbit\Color\Model\Exception\InvalidArgument;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class LABToXYZTest extends TestCase
{
    public static function canConvertLABToXYZDataProvider(): iterable
    {
        yield from [
            // [expected, incoming]
            [new DXYZ(0, 0, 0), new DLAB(0, 0, 0)],
            [new DXYZ(0.612242, 0.48121, 0.264334), new DLAB(0.749012, 0.8, 0.639216)],
            [new DXYZ(0.331111, 0.48121, 0.264334), new DLAB(0.749012, -0.8, 0.639216)],
            [new DXYZ(0.016474, 0.038887, 0.134961), new DLAB(0.233, -0.8, -0.639216)],
//            [new DXYZ(0.253287, 0.188771, 0.079388), new DLAB(0.729412, 0.368627, 0.270588)],
//            [new DXYZ(0.469782, 0.723315, 0.686005), new DLAB(0.290196, 0.968627, 0.8)],
//            [new DXYZ(0.155743, 0.140275, 0.053766), new DLAB(0.54902, 0.372549, 0.211765)],
//            [new DXYZ(0.276051, 0.209124, 0.971701), new DLAB(0.329412, 0.443137, 1)],
//            [new DXYZ(0.240739, 0.182371, 0.075614), new DLAB(0.709804, 0.368627, 0.262745)],
//            [new DXYZ(0.132551, 0.133975, 0.307357), new DLAB(0.294118, 0.403922, 0.588235)],
//            [new DXYZ(0.734573, 0.909497, 0.138865), new DLAB(0.960784, 1, 0.027451)],
        ];
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $converter = $this->getTesteeInstance();

        self::assertInstanceOf(LABToXYZ::class, $converter);
    }

    protected function getTesteeInstance(
        ?int $precision = null,
    ): ICoreConverter {
        return new LABToXYZ(
            precision: $precision ?? ICoreConverter::CALC_PRECISION,
        );
    }

    #[Test]
    #[DataProvider('canConvertLABToXYZDataProvider')]
    public function canConvertLABToXYZ(DXYZ $expected, DLAB $incoming): void
    {
        $converter = $this->getTesteeInstance();

        self::assertEquals($expected, $converter->convert($incoming));
    }

    #[Test]
    public function throwsIfModelIsNotCorrect(): void
    {
        $input = new DXYZ(0, 0, 0);

        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage(
            'Color must be instance of "AlecRabbit\Color\Model\DTO\DLAB", "AlecRabbit\Color\Model\DTO\DXYZ" given.'
        );

        $testee = $this->getTesteeInstance();

        $testee->convert($input);
    }
}
