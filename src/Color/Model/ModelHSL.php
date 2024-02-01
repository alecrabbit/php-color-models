<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model;

use AlecRabbit\Color\Model\A\AColorModel;
use AlecRabbit\Color\Model\Contract\IModelHSL;
use AlecRabbit\Color\Model\DTO\DHSL;

final class ModelHSL extends AColorModel implements IModelHSL
{
    public function __construct()
    {
        parent::__construct(
            DHSL::class
        );
    }
}
