<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Store;

use AlecRabbit\Color\Model\Contract\Converter\IModelConverter;
use AlecRabbit\Color\Model\Contract\IColorModel;
use ArrayObject;
use SplQueue;
use Traversable;

final readonly class ConversionPathFinder implements IConversionPathFinder
{
    private ArrayObject $models;
    private ArrayObject $graph;

    public function __construct(
        private Traversable $modelConverters,
        ArrayObject $models = new ArrayObject(),
        ArrayObject $graph = new ArrayObject(),
        private IKeyCreator $keyCreator = new KeyCreator(),
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
        foreach ($this->modelConverters as $class) {
            $this->setModel($this->keyCreator->extractFrom($class));
            $this->setModel($this->keyCreator->extractTo($class));
        }
    }

    private function setModel(string $key): void
    {
        if (!$this->models->offsetExists($key)) {
            $this->models->offsetSet($key, true);
        }
    }

    private function buildGraph(): void
    {
        /** @var class-string<IColorModel> $model */
        foreach ($this->models as $model => $_) {
            $this->graph->offsetSet($model, []);
        }

        /** @var class-string<IModelConverter> $class */
        foreach ($this->modelConverters as $class) {
            $from = $this->keyCreator->extractFrom($class);

            /** @var array $value */
            $value = $this->graph->offsetGet($from);
            $value[] = $this->keyCreator->extractTo($class);
            $this->graph->offsetSet($from, $value);
        }
    }

    public function findPath(IColorModel $from, IColorModel $to): Traversable
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
