<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Model;


use AlecRabbit\Color\Model\Contract\IColorModel;
use AlecRabbit\Color\Model\DTO\DCMY;
use AlecRabbit\Color\Model\ModelCMY;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class ModelCMYTest extends TestCase
{
    #[Test]
    public function returnsCorrectDtoType(): void
    {
        $model = $this->getTesteeInstance();

        self::assertInstanceOf(ModelCMY::class, $model);
        self::assertEquals(DCMY::class, $model->dtoType());
    }

    private function getTesteeInstance(): IColorModel
    {
        return new ModelCMY();
    }
}
