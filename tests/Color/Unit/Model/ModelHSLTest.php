<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Model;


use AlecRabbit\Color\Model\Contract\IColorModel;
use AlecRabbit\Color\Model\DTO\DHSL;
use AlecRabbit\Color\Model\ModelHSL;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class ModelHSLTest extends TestCase
{
    #[Test]
    public function returnsCorrectDtoType(): void
    {
        $model = $this->getTesteeInstance();

        self::assertInstanceOf(ModelHSL::class, $model);
        self::assertEquals(DHSL::class, $model->dtoType());
    }

    private function getTesteeInstance(): IColorModel
    {
        return new ModelHSL();
    }
}
