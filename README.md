rBiblia bib2xml converter
=========================

This conversion tool allows you to convert Bible translation in one of the supported formats to XML format used by rBiblia. Remaining conversion from *.xml to *.bibx can be done using free [xml2bibx](https://github.com/rBiblia/xml2bibx) translations converter.

Supported input formats are:

Name   | Id    | File extension
-------|-------|---------------
eSword | sword | *.bblx

Compilation steps:
-------------------

You need to have PHP 7.4 or newer installed onto your system.

- clone this repo
- run `composer install`
- run `create-phar.bat` file

`bib2xml.phar` file will be created in `dist` folder.

Conversion steps:
-----------------

Converter requires PHP 7.4 installed onto your system to work.

Example of use:

```cmd
php bib2xml.phar convert input_translation.bblx output_translation.xml sword
```

Original author: [Rafał Toborek](https://kontakt.toborek.info)

Feel free to contribute and [support my work](https://rbiblia.toborek.info/donation/).

Download rBiblia for free [here](https://rbiblia.toborek.info/en-US/).
