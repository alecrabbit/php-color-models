<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Model;


use AlecRabbit\Color\Model\Contract\IColorModel;
use AlecRabbit\Color\Model\DTO\DRGB;
use AlecRabbit\Color\Model\ModelRGB;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class ModelRGBTest extends TestCase
{
    #[Test]
    public function returnsCorrectDtoType(): void
    {
        $model = $this->getTesteeInstance();

        self::assertInstanceOf(ModelRGB::class, $model);
        self::assertEquals(DRGB::class, $model->dtoType());
    }

    private function getTesteeInstance(): IColorModel
    {
        return new ModelRGB();
    }
}
