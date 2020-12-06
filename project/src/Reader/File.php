<?php

declare(strict_types=1);

namespace rBibliaBibleConverter\Reader;

use App\Exception\FileNotFoundException;

class File implements InputReader
{
    /** @var string */
    private $content;

    /** @var string */
    private $originalInput;

    public function __construct(string $filename)
    {
        if (!file_exists($filename)) {
            throw new FileNotFoundException($filename);
        }

        $this->originalInput = $filename;
    }

    public function getContent(): string
    {
        if ($this->content === null) {
            $this->content = file_get_contents($this->originalInput);
        }
        return $this->content;
    }

    public function getOriginalInput(): string
    {
        return $this->originalInput;
    }
}
