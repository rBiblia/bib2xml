<?php

declare(strict_types=1);

namespace rBibliaBibleConverter\Input;

use rBibliaBibleConverter\Value\Translation;

interface InputConverter
{
    public function getTranslation(): Translation;
}
