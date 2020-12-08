<?php

declare(strict_types=1);

namespace rBibliaBibleConverter\Writer;

use rBibliaBibleConverter\Output\OutputConverter;

class FileWriter implements OutputWriter
{
    private $converter;

    public function __construct(OutputConverter $converter)
    {
        $this->converter = $converter;
    }

    public function write(string $filename): bool
    {
        if (false === file_put_contents($filename, $this->converter->getContent())) {
            return false;
        }

        return true;
    }
}
