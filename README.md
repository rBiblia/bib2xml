rBiblia bib2xml converter
=========================

This conversion tool allows you to convert Bible translation in one of the supported formats to XML format used by rBiblia. Remaining conversion from *.xml to *.bibx can be done using free [xml2bibx](https://github.com/rBiblia/xml2bibx) translations converter.

Supported input formats are:

Name               | Id      | File extension
-------------------|---------|---------------
eSword             | sword   | *.bblx, *.mybible
Zefania            | zefania | *.xml
theWord            | word    | *.ot, *.nt, *.ont
tab as a separator | tsv     | *.tsv
MyBible (Android)  | mybible | *.SQLite3 

Compilation steps:
-------------------

You need to have PHP 7.4 or newer installed onto your system.

- clone this repo
- go to the `./project` folder
- run `composer install -o --no-dev`
- go back to the main folder
- run `create-phar.bat` file

`bib2xml.phar` file will be created in `./bin` folder.

Conversion steps:
-----------------

Converter requires PHP 7.4 installed onto your system to work.

Example of use (from the `./bin` folder):

```cmd
php bib2xml.phar convert input_translation.bblx output_translation.xml sword
```

Changelog:
----------

* v0.4.0.0 (2021-05-04):
    - added `tsv` input format support
	- added support for `3es` book
    - small internal fixes
    
* v0.3.0.0 (2020-12-15):
    - added `theWord` input format support
    - added text sanitizer for global use when parsing translations
    - generate default output filename if no output given
    - many internal improvements and fixes

* v0.2.0.0 (2020-12-06):
    - added `Zefania XML` input format support
    - added additional trim rules for eSword input format
    - directory structure fixes

* v0.1.0.0 (2020-12-04):
    - initial release (`eSword` input format support only)

About
-----

Original author: [Rafał Toborek](https://kontakt.toborek.info)

Feel free to contribute and [support my work](https://rbiblia.toborek.info/donation/).

Download rBiblia for free [here](https://rbiblia.toborek.info/en-US/).
