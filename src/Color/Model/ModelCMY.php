<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model;

use AlecRabbit\Color\Model\A\AColorModel;
use AlecRabbit\Color\Model\Contract\IModelCMY;
use AlecRabbit\Color\Model\DTO\DCMY;

final class ModelCMY extends AColorModel implements IModelCMY
{
    public function __construct()
    {
        parent::__construct(
            DCMY::class
        );
    }
}
