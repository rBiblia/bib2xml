@echo off
echo Running crate-phar.php file...
php -f create-phar.php
move dist\bib2xml.phar.gz dist\bib2xml.phar
