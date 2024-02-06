<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Model;


use AlecRabbit\Color\Model\Contract\IColorModel;
use AlecRabbit\Color\Model\Contract\IModelLAB;
use AlecRabbit\Color\Model\DTO\DLAB;
use AlecRabbit\Color\Model\ModelLAB;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class ModelLABTest extends TestCase
{
    #[Test]
    public function returnsCorrectDtoType(): void
    {
        $model = $this->getTesteeInstance();

        self::assertInstanceOf(IModelLAB::class, $model);
        self::assertInstanceOf(ModelLAB::class, $model);
        self::assertEquals(DLAB::class, $model->dtoType());
    }

    private function getTesteeInstance(): IColorModel
    {
        return new ModelLAB();
    }
}
