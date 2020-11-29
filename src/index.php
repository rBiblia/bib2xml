<?php

namespace rBibliaBibleConverter;

require_once '../vendor/autoload.php';

use rBibliaBibleConverter\App;

$parser = new App\AppRunner();
$parser->run();
