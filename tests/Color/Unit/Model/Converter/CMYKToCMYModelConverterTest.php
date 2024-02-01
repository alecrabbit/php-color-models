<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Model\Converter;


use AlecRabbit\Color\Model\Contract\Converter\Core\IDCoreConverter;
use AlecRabbit\Color\Model\Contract\Converter\IModelConverter;
use AlecRabbit\Color\Model\Contract\DTO\DColor;
use AlecRabbit\Color\Model\Converter\CMYKToCMYModelConverter;
use AlecRabbit\Color\Model\ModelCMY;
use AlecRabbit\Color\Model\ModelCMYK;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class CMYKToCMYModelConverterTest extends TestCase
{
    #[Test]
    public function returnsCorrectModelTo(): void
    {
        self::assertEquals(new ModelCMY(), CMYKToCMYModelConverter::to());
    }

    #[Test]
    public function returnsCorrectModelFrom(): void
    {
        self::assertEquals(new ModelCMYK(), CMYKToCMYModelConverter::from());
    }

    #[Test]
    public function canConvert(): void
    {
        $input = $this->getDColorMock();
        $expected = $this->getDColorMock();

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

    private function getDColorMock(): MockObject&DColor
    {
        return $this->createMock(DColor::class);
    }

    protected function getConverterMock(): MockObject&IDCoreConverter
    {
        return $this->createMock(IDCoreConverter::class);
    }

    protected function getTesteeInstance(
        ?IDCoreConverter $converter = null,
    ): IModelConverter {
        return new CMYKToCMYModelConverter(
            converter: $converter ?? $this->getConverterMock(),
        );
    }
}
