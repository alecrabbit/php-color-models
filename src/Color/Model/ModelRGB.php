<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model;

use AlecRabbit\Color\Model\A\AColorModel;
use AlecRabbit\Color\Model\Contract\IModelRGB;
use AlecRabbit\Color\Model\DTO\DRGB;

final class ModelRGB extends AColorModel implements IModelRGB
{
    public function __construct()
    {
        parent::__construct(
            DRGB::class
        );
    }
}
