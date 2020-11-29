<?php

declare(strict_types=1);

namespace rBibliaBibleConverter\Reader;

interface InputReader {
    public function getContent(): string;

    public function getOriginalInput(): string;
}
