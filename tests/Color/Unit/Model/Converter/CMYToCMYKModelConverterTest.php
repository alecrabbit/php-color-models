<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Model\Converter;


use AlecRabbit\Color\Model\Contract\Converter\Core\ICoreConverter;
use AlecRabbit\Color\Model\Contract\Converter\IModelConverter;
use AlecRabbit\Color\Model\Contract\DTO\DColor;
use AlecRabbit\Color\Model\Converter\CMYToCMYKModelConverter;
use AlecRabbit\Color\Model\ModelCMY;
use AlecRabbit\Color\Model\ModelCMYK;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class CMYToCMYKModelConverterTest extends TestCase
{
    #[Test]
    public function returnsCorrectModelTo(): void
    {
        self::assertEquals(new ModelCMYK(), CMYToCMYKModelConverter::to());
    }

    #[Test]
    public function returnsCorrectModelFrom(): void
    {
        self::assertEquals(new ModelCMY(), CMYToCMYKModelConverter::from());
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
            ->willReturn($expected)
        ;

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

    protected function getConverterMock(): MockObject&ICoreConverter
    {
        return $this->createMock(ICoreConverter::class);
    }

    protected function getTesteeInstance(
        ?ICoreConverter $converter = null,
    ): IModelConverter {
        return new CMYToCMYKModelConverter(
            converter: $converter ?? $this->getConverterMock(),
        );
    }
}
