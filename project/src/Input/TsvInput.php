<?php

declare(strict_types=1);

namespace rBibliaBibleConverter\Input;

use rBibliaBibleConverter\Input\Traits\CharSeparatedTrait;

class TsvInput implements InputConverter
{
    use CharSeparatedTrait;

    private string $separator = "\t";
}
