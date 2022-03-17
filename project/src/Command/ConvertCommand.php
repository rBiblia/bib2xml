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
        'sword' => [
            'name' => 'eSword',
            'ext' => ['bblx', 'mybible'],
        ],
        'zefania' => [
            'name' => 'Zefania XML',
            'ext' => ['xml'],
        ],
        'word' => [
            'name' => 'theWord',
            'ext' => ['ot', 'nt', 'ont'],
        ],
        'tsv' => [
            'name' => 'TSV (tab as a separator)',
            'ext' => ['tsv'],
        ],
        'mybible' => [
            'name' => 'MyBible',
            'ext' => ['sqlite3'],
        ],
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
            ->addArgument('output', InputArgument::OPTIONAL, 'Output XML file (eg. trans.xml, if not given then will be auto-generated)')
            ->addArgument('format', InputArgument::OPTIONAL, 'Source file format (if not given then will be auto-detected)')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $source = $input->getArgument('input');
        $sourceRealPath = realpath($source);
        $this->output = $output;

        // input file not found
        if (false === $sourceRealPath || !file_exists($sourceRealPath)) {
            return $this->displayError(sprintf('File `%s` not found', $source));
        }

        // generate output filename
        $destination = $input->getArgument('output');
        if (empty($destination)) {
            $destination = preg_replace('/\.[^.]+$/', '.xml', $sourceRealPath);
        }

        $format = $input->getArgument('format');

        if (empty($format)) {
            $format = $this->getFormatBasedOnExtension($sourceRealPath);
        }

        $inputConverterClass = sprintf('rBibliaBibleConverter\Input\%sInput', ucfirst($format));

        // selected input converter not supported
        if (!class_exists($inputConverterClass)) {
            return $this->displayError(sprintf('Input file format is not supported, supported formats are: <info>%s</info>',
                implode(', ', array_keys(self::SUPPORTED_INPUT_FORMATS))));
        }

        $output->writeln([
            sprintf('Converting: <info>%s</info>', $sourceRealPath),
            sprintf('Output: <info>%s</info>', $destination),
            sprintf('Format: <info>%s</info>', self::SUPPORTED_INPUT_FORMATS[$format]['name']),
        ]);

        $file = new File($sourceRealPath);

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

    private function getFormatBasedOnExtension(string $filename): ?string
    {
        $extension = strtolower(pathinfo($filename, \PATHINFO_EXTENSION));

        foreach (self::SUPPORTED_INPUT_FORMATS as $format => $settings) {
            if (\in_array($extension, $settings['ext'], true)) {
                return $format;
            }
        }

        return null;
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
