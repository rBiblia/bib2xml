<?php

declare(strict_types=1);

namespace App\Exception;

use Exception;
use Throwable;

class FileNotFoundException extends Exception
{
    public function __construct(string $fileName = '', int $code = 0, Throwable $previous = null)
    {
        parent::__construct(sprintf('File `%s` not found', $fileName), $code, $previous);
    }
}
