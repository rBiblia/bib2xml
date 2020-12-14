<?php

declare(strict_types=1);

namespace rBibliaBibleConverter\Text;

class Sanitizer
{
    const CHAR_REPLACE_FROM = [
        '{\cf15\I ',
        '{\cf6 ',
        '{\cf15\I',
        '}',
        ']',
        '[',
        ' (OMITTED TEXT)',
        '\par',
        '--',
        '\u261?',
        '\u322?',
        '\u281?',
        '\u380?',
        '\u347?',
        '\u263?',
        '\u324?',
        '\u378?',
        '\u379?',
        '\u321?',
        '\u346?',
        '\u377?',
        '\u260?',
        '\u8218?',
        '\u352?',
        '\u243?',
        '\u8222?',
        '\u8211?',
        '\u8221?',
        '&amp;',
        '<TS3>', // theWord
        '<CL>', // theWord
        '<Ts>', // theWord
        '<CM>', // theWord
    ];

    const CHAR_REPLACE_TO = [
        '',
        '',
        '',
        '',
        '',
        '',
        '-',
        '',
        '',
        'ą',
        'ł',
        'ę',
        'ż',
        'ś',
        'ć',
        'ń',
        'ź',
        'Ż',
        'Ł',
        'Ś',
        'Ź',
        'Ą',
        '\'',
        'Š',
        'ó',
        '"',
        '"',
        '"',
        '&',
        '',
        ' ',
        '',
        '',
    ];

    public function sanitize(string $text): string
    {
        // remove/convert leftovers
        $output = str_replace(self::CHAR_REPLACE_FROM, self::CHAR_REPLACE_TO, $text);

        // replace tabs with spaces
        $output = preg_replace('/\s+/', ' ', $output);

        return trim($output);
    }
}
