<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Model;


use AlecRabbit\Color\Model\Contract\IColorModel;
use AlecRabbit\Color\Model\Contract\IModelXYZ;
use AlecRabbit\Color\Model\DTO\DXYZ;
use AlecRabbit\Color\Model\ModelXYZ;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class ModelXYZTest extends TestCase
{
    #[Test]
    public function returnsCorrectDtoType(): void
    {
        $model = $this->getTesteeInstance();

        self::assertInstanceOf(IModelXYZ::class, $model);
        self::assertInstanceOf(ModelXYZ::class, $model);
        self::assertEquals(DXYZ::class, $model->dtoType());
    }

    private function getTesteeInstance(): IColorModel
    {
        return new ModelXYZ();
    }
}
