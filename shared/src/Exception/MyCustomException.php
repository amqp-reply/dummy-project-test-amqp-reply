<?php
declare(strict_types=1);

namespace Shared\Exception;

use Throwable;

class MyCustomException extends \LogicException
{
    public function __construct(string $message = 'My custom exception', int $code = 401, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
