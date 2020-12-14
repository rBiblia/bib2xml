<?php

declare(strict_types=1);

namespace rBibliaBibleConverter\Command;

use rBibliaBibleConverter\Bible\Books;
use rBibliaBibleConverter\Input\InputConverter;
use rBibliaBibleConverter\Output\XmlOutput;
use rBibliaBibleConverter\Reader\File;
use rBibliaBibleConverter\Text\Sanitizer;
use rBibliaBibleConverter\Writer\FileWriter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ConvertCommand extends Command
{
    const SUPPORTED_INPUT_FORMATS = [
        'sword' => 'eSword',
        'zefania' => 'Zefania XML',
        'word' => 'theWord',
    ];

    /** @var string */
    protected static $defaultName = 'convert';

    /** @var OutputInterface */
    private $output;

    protected function configure(): void
    {
        $this
            ->setAliases(['c'])
            ->setDescription('Converts given translation file to XML format')
            ->setHelp('Convert Bible translation in one of the supported formats to XML file used by rBiblia.')
            ->addArgument('input', InputArgument::REQUIRED, 'Input translation file (eg. translation.bblx)')
            ->addArgument('output', InputArgument::OPTIONAL, 'Output XML file (eg. translation.xml)')
            ->addArgument('format', InputArgument::OPTIONAL, 'Source file format', 'sword')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;

        $format = $input->getArgument('format');
        $source = realpath($input->getArgument('input'));

        // generate output filename
        $destination = $input->getArgument('output');
        if (empty($destination)) {
            $destination = preg_replace('/\.[^.]+$/', '.xml', $source);
        }

        // input file not found
        if (!file_exists($source)) {
            return $this->displayError(sprintf('File `%s` not found', $source));
        }

        // selected input converter not supported
        $inputConverterClass = sprintf('rBibliaBibleConverter\Input\%sInput', ucfirst($format));
        if (!class_exists($inputConverterClass)) {
            return $this->displayError(sprintf('Output file format is not supported, supported formats are: <info>%s</info>',
                implode(', ', array_keys(self::SUPPORTED_INPUT_FORMATS))));
        }

        $output->writeln([
            sprintf('Converting: <info>%s</info>', $source),
            sprintf('Output: <info>%s</info>', $destination),
            sprintf('Format: <info>%s</info>', self::SUPPORTED_INPUT_FORMATS[$format]),
        ]);

        $file = new File($source);

        $this->output->writeln([
            '',
            'Reading input translation...',
        ]);
        /** @var InputConverter $inputConverter */
        $inputConverter = new $inputConverterClass($file, new Sanitizer(), new Books());
        $translation = $inputConverter->getTranslation();
        $translation->sort();

        $this->output->writeln('Converting data...');
        $outputConverter = new XmlOutput($translation);

        $this->output->writeln('Saving output to file...');
        $writer = new FileWriter($outputConverter);
        $writingResult = $writer->write($destination);

        if (!$writingResult) {
            return $this->displayError('Cannot write output to file');
        }

        $output->writeln([
            '',
            'File successfully converted.',
        ]);

        return Command::SUCCESS;
    }

    private function displayError(string $message): int
    {
        $this->output->writeln([
            '',
            sprintf('<error>Error:</error> %s', $message),
        ]);

        return Command::FAILURE;
    }
}
