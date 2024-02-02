<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Store;

use AlecRabbit\Color\Model\Contract\IColorModel;

interface IConversionPathFinder
{
    public function findPath(IColorModel $from, IColorModel $to): \Traversable;
}
