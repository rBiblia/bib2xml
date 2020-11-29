<?php

declare(strict_types=1);

namespace rBibliaBibleConverter\Output;

interface OutputConverter {
    public function getContent(): string;
}
