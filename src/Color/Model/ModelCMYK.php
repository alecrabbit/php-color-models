<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model;

use AlecRabbit\Color\Model\A\AColorModel;
use AlecRabbit\Color\Model\Contract\IModelCMYK;
use AlecRabbit\Color\Model\DTO\DCMYK;

final class ModelCMYK extends AColorModel implements IModelCMYK
{
    public function __construct()
    {
        parent::__construct(
            DCMYK::class
        );
    }
}
