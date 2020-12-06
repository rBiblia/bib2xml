<?php

declare(strict_types=1);

namespace rBibliaBibleConverter\Writer;

interface OutputWriter {
    public function write(string $filename): bool;
}
