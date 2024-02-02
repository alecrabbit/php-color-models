<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Store;

use AlecRabbit\Color\Model\Contract\IColorModel;
use Traversable;

interface IConversionPathFinder
{
    public function findPath(IColorModel $from, IColorModel $to): Traversable;
}
