<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Model\Converter;


use AlecRabbit\Color\Model\Contract\Converter\Core\ICoreConverter;
use AlecRabbit\Color\Model\Contract\Converter\IModelConverter;
use AlecRabbit\Color\Model\Converter\LABToXYZModelConverter;
use AlecRabbit\Color\Model\DTO\DLAB;
use AlecRabbit\Color\Model\DTO\DXYZ;
use AlecRabbit\Color\Model\ModelLAB;
use AlecRabbit\Color\Model\ModelXYZ;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class LABToXYZModelConverterTest extends TestCase
{
    #[Test]
    public function returnsCorrectModelTo(): void
    {
        self::assertEquals(new ModelXYZ(), LABToXYZModelConverter::to());
    }

    #[Test]
    public function returnsCorrectModelFrom(): void
    {
        self::assertEquals(new ModelLAB(), LABToXYZModelConverter::from());
    }

    #[Test]
    public function canConvert(): void
    {
        $input = new DLAB(0, 0, 0);
        $expected = new DXYZ(0, 0, 0);

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

    protected function getConverterMock(): MockObject&ICoreConverter
    {
        return $this->createMock(ICoreConverter::class);
    }

    protected function getTesteeInstance(
        ?ICoreConverter $converter = null,
    ): IModelConverter {
        return new LABToXYZModelConverter(
            converter: $converter ?? $this->getConverterMock(),
        );
    }

}
