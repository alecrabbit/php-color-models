<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Model\Converter;


use AlecRabbit\Color\Model\Contract\Converter\Core\IDCoreConverter;
use AlecRabbit\Color\Model\Contract\Converter\IModelConverter;
use AlecRabbit\Color\Model\Converter\RGBToHSLModelConverter;
use AlecRabbit\Color\Model\DTO\DHSL;
use AlecRabbit\Color\Model\DTO\DRGB;
use AlecRabbit\Color\Model\ModelHSL;
use AlecRabbit\Color\Model\ModelRGB;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class RGBToHSLModelConverterTest extends TestCase
{
    #[Test]
    public function returnsCorrectModelTo(): void
    {
        self::assertEquals(new ModelHSL(), RGBToHSLModelConverter::to());
    }

    #[Test]
    public function returnsCorrectModelFrom(): void
    {
        self::assertEquals(new ModelRGB(), RGBToHSLModelConverter::from());
    }

    #[Test]
    public function canConvert(): void
    {
        $input = new DRGB(0, 0, 0);
        $expected = new DHSL(0, 0, 0);

        $converter = $this->getConverterMock();
        $converter
            ->expects($this->once())
            ->method('convert')
            ->willReturn($expected);

        $testee = $this->getTesteeInstance(
            converter: $converter,
        );

        $result = $testee->convert($input);

        self::assertSame($expected, $result);
    }

    protected function getConverterMock(): MockObject&IDCoreConverter
    {
        return $this->createMock(IDCoreConverter::class);
    }

    protected function getTesteeInstance(
        ?IDCoreConverter $converter = null,
    ): IModelConverter {
        return new RGBToHSLModelConverter(
            converter: $converter ?? $this->getConverterMock(),
        );
    }

}
