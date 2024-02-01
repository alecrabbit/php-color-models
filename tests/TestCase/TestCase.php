<?php

declare(strict_types=1);


namespace AlecRabbit\Tests\TestCase;

use AlecRabbit\Tests\TestCase\Helper\PickLock;
use AlecRabbit\Tests\TestCase\Helper\Stringify;
use AlecRabbit\Tests\TestCase\Mixin\AppRelatedConstTrait;
use ArrayAccess;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Throwable;

use function array_key_exists;
use function is_array;
use function is_string;

abstract class TestCase extends PHPUnitTestCase
{
    use AppRelatedConstTrait;

    final protected const REPEATS = 10;
    final protected const FLOAT_EQUALITY_DELTA = 0.0000001;

    protected static function getPropertyValue(object|string $objectOrClass, string $property): mixed
    {
        return PickLock::getValue($objectOrClass, $property);
    }

    protected static function setPropertyValue(object|string $objectOrClass, string $propertyName, mixed $value): void
    {
        PickLock::setValue($objectOrClass, $propertyName, $value);
    }

    protected static function callMethod(mixed $objectOrClass, string $methodName, ...$args): mixed
    {
        return PickLock::callMethod($objectOrClass, $methodName, ...$args);
    }

    protected static function failTest(string|Throwable $messageOrException): never
    {
        $message =
            is_string($messageOrException)
                ? $messageOrException
                : 'Exception not thrown: ' . Stringify::throwable($messageOrException);

        self::fail($message);
    }

    protected static function exceptionNotThrown(
        Throwable $throwable,
        ?string $exceptionMessage = null
    ): string {
        if (
            is_string($throwable)
            && class_exists($throwable)
            && is_subclass_of($throwable, Throwable::class)
        ) {
            $throwable = new $throwable($exceptionMessage ?? '');
        }
        return 'Exception not thrown: ' . Stringify::throwable($throwable);
    }

    protected function setUp(): void
    {
    }

    protected function tearDown(): void
    {
    }

    protected function expectsException(mixed $expected): ?Throwable
    {
        if (
            (is_array($expected) || $expected instanceof ArrayAccess)
            && array_key_exists(self::EXCEPTION, $expected)
        ) {
            $exceptionClass = $expected[self::EXCEPTION][self::CLASS_];
            $exceptionMessage = '';
            $this->expectException($exceptionClass);
            if (array_key_exists(self::MESSAGE, $expected[self::EXCEPTION])) {
                $exceptionMessage = $expected[self::EXCEPTION][self::MESSAGE];
                $this->expectExceptionMessage($exceptionMessage);
            }
            return new $exceptionClass($exceptionMessage);
        }
        return null;
    }

    protected function wrapExceptionTest(
        callable $test,
        Throwable $throwable,
        array $args = []
    ): void {
        $this->expectException($throwable::class);
        $this->expectExceptionMessage($throwable->getMessage());

        $test(...$args);

        self::fail(
            'Exception not thrown: ' . Stringify::throwable($throwable)
        );
    }
}
