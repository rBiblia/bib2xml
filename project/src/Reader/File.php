<?php

declare(strict_types=1);

namespace rBibliaBibleConverter\Reader;

use App\Exception\FileIsEmptyException;
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

        if (0 === filesize($filename)) {
            throw new FileIsEmptyException($filename);
        }

        $this->originalInput = $filename;
    }

    public function getContent(): string
    {
        if (null === $this->content) {
            $this->content = $this->removeBOM(file_get_contents($this->originalInput));
        }

        return $this->content;
    }

    public function getOriginalInput(): string
    {
        return $this->originalInput;
    }

    private function removeBOM(string $content): string
    {
        $bom = pack('H*', 'EFBBBF');
        $content = preg_replace("/^$bom/", '', $content);

        return $content;
    }
}
