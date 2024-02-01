<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Functional\Model\Converter;


use AlecRabbit\Color\Model\Contract\Converter\IModelConverter;
use AlecRabbit\Color\Model\Contract\DTO\DColor;
use AlecRabbit\Color\Model\Converter\CMYKToCMYModelConverter;
use AlecRabbit\Color\Model\DTO\DCMY;
use AlecRabbit\Color\Model\DTO\DCMYK;
use AlecRabbit\Color\Model\DTO\DHSL;
use AlecRabbit\Color\Model\DTO\DRGB;
use AlecRabbit\Color\Model\Exception\InvalidArgument;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class CMYKToCMYModelConverterTest extends TestCase
{
    public static function incorrectInputDataProvider(): iterable
    {
        foreach (self::incorrectInputDataFeeder() as $item) {
            yield [$item[0], "Color must be instance of \"{$item[1]}\", \"{$item[2]}\" given."];
        }
    }

    private static function incorrectInputDataFeeder(): iterable
    {
        yield from [
            [new DHSL(0, 0, 0), DCMYK::class, DHSL::class],
            [new DRGB(0, 0, 0, 0), DCMYK::class, DRGB::class],
            [new DCMY(0, 0, 0), DCMYK::class, DCMY::class],
        ];
    }

    public static function canConvertDataProvider(): iterable
    {
        yield from [
            [new DCMY(1, 1, 1), new DCMYK(0, 0, 0, 1)],
        ];
    }

    #[Test]
    #[DataProvider('canConvertDataProvider')]
    public function canConvert(DColor $expected, DColor $input): void
    {
        $testee = $this->getTesteeInstance();

        self::assertEquals($expected, $testee->convert($input));
    }

    protected function getTesteeInstance(): IModelConverter
    {
        return new CMYKToCMYModelConverter();
    }

    #[Test]
    #[DataProvider('incorrectInputDataProvider')]
    public function throwsIfModelIsNotCorrect(DColor $dto, string $message): void
    {
        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage($message);

        $testee = $this->getTesteeInstance();

        $testee->convert($dto);
    }
}
