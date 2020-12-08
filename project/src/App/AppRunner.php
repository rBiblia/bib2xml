<?php

declare(strict_types=1);

namespace rBibliaBibleConverter\App;

use rBibliaBibleConverter\Command\ConvertCommand;
use Symfony\Component\Console\Application;

class AppRunner
{
    const VERSION = '0.2.0.0';
    const NAME = 'rBiblia bib2xml converter';

    /** @var Application */
    private $application;

    public function __construct()
    {
        $this->application = new Application();

        $this->application->setName(self::NAME);
        $this->application->setVersion(self::VERSION);

        $convertCommand = new ConvertCommand();
        $this->application->add($convertCommand);
    }

    public function run(): void
    {
        $this->application->run();
    }
}
