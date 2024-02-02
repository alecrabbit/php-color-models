<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model;

use AlecRabbit\Color\Model\A\AColorModel;
use AlecRabbit\Color\Model\Contract\IModelXYZ;
use AlecRabbit\Color\Model\DTO\DXYZ;

final class ModelXYZ extends AColorModel implements IModelXYZ
{
    public function __construct()
    {
        parent::__construct(
            DXYZ::class
        );
    }
}
