<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Store;

use AlecRabbit\Color\Model\Contract\Converter\Builder\IChainConverterBuilder;
use AlecRabbit\Color\Model\Contract\Converter\IDColorConverter;
use AlecRabbit\Color\Model\Contract\Converter\IModelConverter;
use AlecRabbit\Color\Model\Contract\IColorModel;
use AlecRabbit\Color\Model\Contract\Store\IConverterStore;
use AlecRabbit\Color\Model\Converter\Builder\ChainConverterBuilder;
use AlecRabbit\Color\Model\Exception\InvalidArgument;
use ArrayObject;
use SplQueue;
use Traversable;

final class ConverterStore implements IConverterStore
{
    /** @var Array<class-string<IModelConverter>> */
    private static array $modelConverters = [];
    private readonly ArrayObject $models;
    private readonly ArrayObject $graph;

    public function __construct(
        ArrayObject $models = new ArrayObject(),
        ArrayObject $graph = new ArrayObject(),
        private readonly IChainConverterBuilder $chainConverterBuilder = new ChainConverterBuilder(),
    ) {
        $this->models = $models;
        $this->graph = $graph;

        $this->initialize();
    }

    private function initialize(): void
    {
        $this->buildModels();
        $this->buildGraph();
    }

    private function buildModels(): void
    {
        /** @var class-string<IModelConverter> $class */
        foreach (self::$modelConverters as $class) {
            $this->models->offsetSet(self::extractFrom($class), true);
            $this->models->offsetSet(self::extractTo($class), true);
        }
    }

    /**
     * @param class-string<IModelConverter> $class
     * @return class-string<IColorModel>
     */
    protected static function extractFrom(string $class): string
    {
        return $class::from()::class;
    }

    /**
     * @param class-string<IModelConverter> $class
     * @return class-string<IColorModel>
     */
    protected static function extractTo(string $class): string
    {
        return $class::to()::class;
    }

    private function buildGraph(): void
    {
        /** @var class-string<IColorModel> $model */
        foreach ($this->models as $model => $_) {
            $this->graph->offsetSet($model, []);
        }

        /** @var class-string<IModelConverter> $class */
        foreach (self::$modelConverters as $class) {
            $from = self::extractFrom($class);

            /** @var array $value */
            $value = $this->graph->offsetGet($from);
            $value[] = self::extractTo($class);
            $this->graph->offsetSet($from, $value);
        }
    }

    public static function add(string ...$classes): void
    {
        foreach ($classes as $class) {
            self::assertClass($class);

            self::$modelConverters[self::createKey($class)] = $class;
        }
    }

    private static function assertClass(string $class): void
    {
        if (!is_subclass_of($class, IModelConverter::class)) {
            throw new InvalidArgument(
                sprintf(
                    'Class "%s" is not subclass of "%s".',
                    $class,
                    IModelConverter::class
                )
            );
        }
    }

    /**
     * @param class-string<IModelConverter> $class
     */
    private static function createKey(string $class): string
    {
        return self::extractFrom($class) . '::' . self::extractTo($class);
    }

    public function getColorConverter(IColorModel $from, IColorModel $to): IDColorConverter
    {
        return $this->createColorConverter(
            $this->findConversionPath($from, $to)
        );
    }

    /**
     * @param iterable<class-string<IColorModel>> $conversionPath
     */
    private function createColorConverter(iterable $conversionPath): IDColorConverter
    {
        return $this->chainConverterBuilder
            ->withConverters($this->getModelConverters())
            ->forPath($conversionPath)
            ->build();
    }

    /**
     * @return Traversable<class-string<IModelConverter>>
     */
    private function getModelConverters(): Traversable
    {
        yield from self::$modelConverters;
    }

    /**
     * @param IColorModel $from
     * @param IColorModel $to
     *
     * @return Traversable<class-string<IColorModel>>
     */
    private function findConversionPath(IColorModel $from, IColorModel $to): Traversable
    {
        $visited = [];
        $queue = new SplQueue();

        $fromClass = $from::class;
        $toClass = $to::class;

        $queue->enqueue([$fromClass]);
        $visited[$fromClass] = true;

        while (!$queue->isEmpty()) {
            /** @var Array<class-string<IColorModel>> $path */
            $path = $queue->dequeue();
            $node = end($path);

            if ($node === $toClass) {
                yield from $path;
            }

            $neighbours = $this->graph[$node] ?? [];

            /** @var class-string<IColorModel> $neighbor */
            foreach ($neighbours as $neighbor) {
                if (!isset($visited[$neighbor])) {
                    $visited[$neighbor] = true;
                    $newPath = $path;
                    $newPath[] = $neighbor;
                    $queue->enqueue($newPath);
                }
            }
        }
    }
}
