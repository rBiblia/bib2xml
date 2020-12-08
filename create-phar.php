<?php

$distDir = './bin';
$srcPath = './project';
$pharFile = 'bib2xml.phar';
$fullPharPath = sprintf('%s/%s', $distDir, $pharFile);
$fullGzPath = sprintf('%s/%s.gz', $distDir, $pharFile);

printf('Creating Phar file...%s', PHP_EOL);

if (file_exists($fullPharPath)) {
    unlink($fullPharPath);
}

if (file_exists($fullGzPath)) {
    unlink($fullGzPath);
}

$phar = new Phar($fullPharPath);

$phar->buildFromDirectory($srcPath);
$phar->setDefaultStub('index.php');
$phar->compress(Phar::GZ);

printf('%s successfully created%s', $pharFile, PHP_EOL);
