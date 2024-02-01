<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Model;


use AlecRabbit\Color\Model\Contract\IColorModel;
use AlecRabbit\Color\Model\DTO\DCMYK;
use AlecRabbit\Color\Model\ModelCMYK;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class ModelCMYKTest extends TestCase
{
    #[Test]
    public function returnsCorrectDtoType(): void
    {
        $model = $this->getTesteeInstance();

        self::assertInstanceOf(ModelCMYK::class, $model);
        self::assertEquals(DCMYK::class, $model->dtoType());
    }

    private function getTesteeInstance(): IColorModel
    {
        return new ModelCMYK();
    }
}
