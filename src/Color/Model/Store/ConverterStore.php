<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Store;

use AlecRabbit\Color\Model\Builder\ChainConverterFactoryBuilder;
use AlecRabbit\Color\Model\Builder\ConversionPathFinderBuilder;
use AlecRabbit\Color\Model\Contract\Converter\IConverter;
use AlecRabbit\Color\Model\Contract\Converter\IModelConverter;
use AlecRabbit\Color\Model\Contract\IColorModel;
use AlecRabbit\Color\Model\Contract\Store\IConverterStore;
use AlecRabbit\Color\Model\Exception\InvalidArgument;
use ArrayObject;
use Traversable;

final class ConverterStore implements IConverterStore
{
    /** @var Array<class-string<IModelConverter>> */
    private static array $modelConverters = [];

    public static function add(string ...$classes): void
    {
        foreach ($classes as $class) {
            self::assertClass($class);

            self::$modelConverters[self::createKey($class)] = $class;
        }
    }

    /**
     * @throws InvalidArgument
     */
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

    protected static function createKey(string $class): string
    {
        static $keyCreator = new KeyCreator();

        return $keyCreator->create($class);
    }

    public function getConverter(IColorModel $from, IColorModel $to): IConverter
    {
        return $this->createConverterGetter()->get($from, $to);
    }

    protected function createConverterGetter(): ConverterGetter
    {
        return new ConverterGetter(
            modelConverters: $this->getModelConverters(),
            converterFactoryBuilder: new ChainConverterFactoryBuilder(),
            conversionPathFinderBuilder: new ConversionPathFinderBuilder(),
        );
    }

    /**
     * @return Traversable<class-string<IModelConverter>>
     */
    private function getModelConverters(): Traversable
    {
        return new ArrayObject(self::$modelConverters);
    }
}
