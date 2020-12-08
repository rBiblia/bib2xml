@echo off
echo Running crate-phar.php file...
php -f create-phar.php
move bin\bib2xml.phar.gz bin\bib2xml.phar
