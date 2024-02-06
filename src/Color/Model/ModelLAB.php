<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model;

use AlecRabbit\Color\Model\A\AColorModel;
use AlecRabbit\Color\Model\Contract\IModelLAB;
use AlecRabbit\Color\Model\DTO\DLAB;

final class ModelLAB extends AColorModel implements IModelLAB
{
    public function __construct()
    {
        parent::__construct(
            DLAB::class
        );
    }
}
