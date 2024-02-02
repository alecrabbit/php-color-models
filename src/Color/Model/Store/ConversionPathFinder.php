<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Store;

use AlecRabbit\Color\Model\Contract\IColorModel;

final readonly class ConversionPathFinder implements IConversionPathFinder
{

    public function findPath(IColorModel $from, IColorModel $to): \Traversable
    {
        // TODO: Implement findPath() method.
        throw new \RuntimeException(__METHOD__ . ' Not implemented.');
    }
}
