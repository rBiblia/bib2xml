<?php

declare(strict_types=1);

namespace rBibliaBibleConverter\Bible;

class Books
{
    const ALIASES = [
        'gen' => ['gen', 'IMojżeszowe', 'genesis', 'Gen', 'I Księga Mojżesza', 'vol1', '1', 'rodz'],
        'exo' => ['exo', 'IIMojżeszowe', 'exodus', 'Exod', 'II Księga Mojżesza', 'vol2', '2', 'wyjscia'],
        'lev' => ['lev', 'IIIMojżeszowe', 'leviticus', 'Lev', 'III Księga Mojżesza', 'vol3', '3', 'kapl'],
        'num' => ['num', 'IVMojżeszowe', 'numbers', 'Num', 'IV Księga Mojżesza', 'vol4', '4', 'liczb'],
        'deu' => ['deu', 'VMojżeszowe', 'deuteronomy', 'Deut', 'V Księga Mojżesza', 'vol5', '5', 'powt pr'],
        'jos' => ['jos', 'Jozue', 'joshua', 'Josh', 'Księga Jezusa syna Nuna', 'vol6', '6', 'joz'],
        'jdg' => ['jdg', 'Sędziów', 'judges', 'Judg', 'Księga Sędziów', 'vol7', '7', 'sedz'],
        'rut' => ['rut', 'Ruty', 'ruth', 'Ruth', 'Księga Rut', 'vol8', '8'],
        '1sa' => ['1sa', 'sa1', 'ISamuelowe', '1samuel', '1Sam', '1 Samuela', 'vol9', '9', '1 sam'],
        '2sa' => ['2sa', 'sa2', 'IISamuelowe', '2samuel', '2Sam', '2 Samuela', 'vol10', '10', '2 sam'],
        '1ki' => ['1ki', 'kg1', 'IKrólewskie', '1kings', '1Kgs', 'Pierwsza Księga Królów', 'vol11', '11', '1 krol'],
        '2ki' => ['2ki', 'kg2', 'IIKrólewskie', '2kings', '2Kgs', 'Druga Księga Królów', 'vol12', '12', '2 krol'],
        '1ch' => ['1ch', 'ch1', 'IKroniki', '1chronicles', '1Chr', '1 Kronik', 'vol13', '13', '1 kron'],
        '2ch' => ['2ch', 'ch2', 'IIKroniki', '2chronicles', '2Chr', '2 Kronik', 'vol14', '14', '2 kron'],
        'ezr' => ['ezr', 'Ezdrasza', 'ezra', 'Ezra', 'Księga Ezdrasza', 'vol15', '15', 'ezd'],
        'neh' => ['neh', 'Nehemiasza', 'nehemiah', 'Neh', 'Księga Nehemiasza', 'vol16', '16', 'nehem'],
        'tob' => ['tob', '69'],
        'jdt' => ['jdt', '67'],
        'est' => ['est', 'Ester', 'esther', 'Esth', 'Księga Estery', 'vol17', '17'],
        '1ma' => ['ma1', '72'],
        '2ma' => ['ma2', '73'],
        '3ma' => ['ma3'],
        '4ma' => ['ma4'],
        'job' => ['job', 'Hiobowe', 'job', 'Job', 'Księga Ijoba', 'vol18', '18', 'hioba'],
        'psa' => ['psa', 'Psalmów', 'psalms', 'Ps', 'Księga Psalmów', 'vol19', '19', 'ps'],
        'pro' => ['pro', 'Przypowieści', 'proverbs', 'Prov', 'Przypowieści Salomona', 'vol20', '20', 'prz'],
        'ecc' => ['ecc', 'Ekklesiastesa', 'ecclesiastes', 'Eccl', 'Księga Koheleta', 'vol21', '21', 'kazn'],
        'sol' => ['sol', 'Pieśni', 'songofsolomon', 'Song', 'Pieśń nad pieśniami', 'vol22', '22', 'piesn'],
        'wis' => ['wis', '68'],
        'sip' => ['sip'],
        'sir' => ['sir', '70'],
        'pss' => ['pss'],
        'isa' => ['isa', 'Ezjasza', 'isaiah', 'Isa', 'Księga Izajasza', 'vol23', '23', 'izaj'],
        'jer' => ['jer', 'Jeremiasza', 'jeremiah', 'Jer', 'Księga Jeremiasza', 'vol24', '24', 'jer'],
        'lam' => ['lam', 'Lamenty', 'lamentations', 'Lam', 'Treny', 'vol25', '25'],
        'bar' => ['bar', '71'],
        'eze' => ['eze', 'Ezechiela', 'ezekiel', 'Ezek', 'Księga Ezechiela', 'vol26', '26', 'ezech'],
        'dan' => ['dan', 'Daniela', 'daniel', 'Dan', 'Księga Daniela', 'vol27', '27'],
        'hos' => ['hos', 'Ozeasza', 'hosea', 'Hos', 'Księga Ozeasza', 'vol28', '28', 'oz'],
        'joe' => ['joe', 'Joela', 'joel', 'Joel', 'Księga Joela', 'vol29', '29', 'joela'],
        'amo' => ['amo', 'Amosa', 'amos', 'Amos', 'Księga Amosa', 'vol30', '30', 'am'],
        'oba' => ['oba', 'Abdiasza', 'obadiah', 'Obad', 'Księga Abdjasza', 'vol31', '31', 'abd'],
        'jon' => ['jon', 'Jonasza', 'jonah', 'Jonah', 'Księga Jonasza', 'vol32', '32'],
        'mic' => ['mic', 'Micheasza', 'micah', 'Mic', 'Księga Micheasza', 'vol33', '33', 'mich'],
        'nah' => ['nah', 'Nahuma', 'nahum', 'Nah', 'Ksiega Nahuma', 'vol34', '34', 'nahuma'],
        'hab' => ['hab', 'Abakuka', 'habakkuk', 'Hab', 'Księga Habakuka', 'vol35', '35'],
        'zep' => ['zep', 'Sofoniasza', 'zephaniah', 'Zeph', 'Księga Sofonjasza', 'vol36', '36', 'sof'],
        'hag' => ['hag', 'Aggeusza', 'haggai', 'Hag', 'Księga Aggeusza', 'vol37', '37', 'agg'],
        'zec' => ['zac', 'Zachariasza', 'zechariah', 'Zech', 'Księga Zacharjasza', 'vol38', '38', 'zach'],
        'mal' => ['mal', 'Malachiasza', 'malachi', 'Mal', 'Księga Malachjasza', 'vol39', '39', 'malach'],
        'mat' => ['mat', 'Mateusz', 'matthew', 'Matt', 'Ewangelia Mateusza', 'vol40', '40'],
        'mar' => ['mar', 'Marek', 'mark', 'Mark', 'Ewangelia Marka', 'vol41', '41', 'marka'],
        'luk' => ['luk', 'Łukasz', 'luke', 'Luke', 'Ewangelia Łukasza', 'vol42', '42', 'luk'],
        'joh' => ['joh', 'Jan', 'john', 'John', 'Ewangelia Jana', 'vol43', '43', 'jana'],
        'act' => ['act', 'Dzieje', 'act', 'Acts', 'Dokonania apostołów', 'vol44', '44', 'dzieje'],
        'rom' => ['rom', 'Rzymianów', 'romans', 'Rom', 'List do Rzymian', 'vol45', '45', 'rzym'],
        '1co' => ['1co', 'co1', 'IKoryntów', '1corinthians', '1Cor', 'Pierwszy list do Koryntian', 'vol46', '46', '1 kor'],
        '2co' => ['2co', 'co2', 'IIKoryntów', '2corinthians', '2Cor', 'Drugi list do Koryntian', 'vol47', '47', '2 kor'],
        'gal' => ['gal', 'Galatów', 'galatians', 'Gal', 'List do Galacjan', 'vol48', '48'],
        'eph' => ['eph', 'Efezów', 'ephesians', 'Eph', 'List do Efezjan', 'vol49', '49', 'efez'],
        'phi' => ['phi', 'Filipensów', 'philippians', 'Phil', 'List do Filippian', 'vol50', '50', 'filip'],
        'col' => ['col', 'Kolosenów', 'colossians', 'Col', 'List do Kolosan', 'vol51', '51', 'kol'],
        '1th' => ['1th', 'th1', 'ITessalonicensów', '1thessalonians', '1Thess', 'Pierwszy list do Tesaloniczan', 'vol52', '52', '1 tes'],
        '2th' => ['2th', 'th2', 'IITessalonicensów', '2thessalonians', '2Thess', 'Drugi list do Tesaloniczan', 'vol53', '53', '2 tes'],
        '1ti' => ['1ti', 'ti1', 'ITymoteusza', '1timothy', '1Tim', 'Pierwszy list do Tymoteusza', 'vol54', '54', '1 tym'],
        '2ti' => ['2ti', 'ti2', 'IITymoteusza', '2timothy', '2Tim', 'Drugi list do Tymoteusza', 'vol55', '55', '2 tym'],
        'tit' => ['tit', 'Tytus', 'titus', 'Titus', 'List do Tytusa', 'vol56', '56', 'tyt'],
        'phm' => ['plm', 'Filemon', 'philemon', 'Phlm', 'List do Filemona', 'vol57', '57', 'filem'],
        'heb' => ['heb', 'Żydów', 'hebrews', 'Heb', 'List do Hebrajczyków', 'vol58', '58', 'hebr'],
        'jam' => ['jam', 'Jakub', 'james', 'Jas', 'List Jakóba', 'vol59', '59', 'jak'],
        '1pe' => ['1pe', 'pe1', 'IPiotra', '1peter', '1Pet', 'Pierwszy list Piotra', 'vol60', '60', '1 piotra'],
        '2pe' => ['2pe', 'pe2', 'IIPiotra', '2peter', '2Pet', 'Drugi list Piotra', 'vol61', '61', '2 piotra'],
        '1jo' => ['1jo', 'jo1', 'IJana', '1john', '1John', 'Pierwszy List Jana', 'vol62', '62', '1 jana'],
        '2jo' => ['2jo', 'jo2', 'IIJana', '2john', '2John', 'Drugi List Jana', 'vol63', '63', '2 jana'],
        '3jo' => ['3jo', 'jo3', 'IIIJana', '3john', '3John', 'Trzeci List Jana', 'vol64', '64', '3 jana'],
        'jud' => ['jde', 'Judy', 'jude', 'Jude', 'List Judasa', 'vol65', '65', 'judy'],
        'rev' => ['rev', 'Zjawienie', 'revelations', 'Rev', 'Objawienie spisane przez Jana', 'vol66', '66', 'obj'],
        'epj' => ['epj'],
        'sus' => ['sus', '87'],
        'bel' => ['bel', '88'],
        'pra' => ['pra'],
        'prm' => ['prm', '76'],
        'lao' => ['lao'],
        '4es' => ['4es'],
    ];

    public function convertNameToOneOfTheSupportedBooksId(string $name): string
    {
        $name = trim(strtolower($name));

        foreach (self::ALIASES as $bookId => $b) {
            foreach ($b as $alias) {
                if ($name === strtolower($alias)) {
                    return $bookId;
                }
            }
        }

        return $name;
    }
}
