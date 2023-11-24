<?php

declare(strict_types=1);

namespace rBibliaBibleConverter\Input;

use rBibliaBibleConverter\Input\Traits\CharSeparatedTrait;

class CsvInput implements InputConverter
{
    use CharSeparatedTrait;

    private string $separator = ';';
}
