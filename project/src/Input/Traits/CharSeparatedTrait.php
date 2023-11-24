<?php

declare(strict_types=1);

namespace rBibliaBibleConverter\Input\Traits;

use rBibliaBibleConverter\Bible\Books;
use rBibliaBibleConverter\Reader\InputReader;
use rBibliaBibleConverter\Text\Sanitizer;
use rBibliaBibleConverter\Value\About;
use rBibliaBibleConverter\Value\Book;
use rBibliaBibleConverter\Value\Chapter;
use rBibliaBibleConverter\Value\Translation;
use rBibliaBibleConverter\Value\Verse;

trait CharSeparatedTrait
{
    /** @var InputReader */
    private $input;

    /** @var Sanitizer */
    private $sanitizer;

    /** @var Books */
    private $books;

    public function __construct(InputReader $input, Sanitizer $sanitizer, Books $books)
    {
        $this->input = $input;
        $this->sanitizer = $sanitizer;
        $this->books = $books;
    }

    public function getTranslation(): Translation
    {
        $translationArray = [];

        $content = explode(\PHP_EOL, $this->input->getContent());
        foreach ($content as $line) {
            if (empty(trim($line))) {
                continue;
            }

            $verseAsArray = explode($this->separator, $line);

            $bookId = $verseAsArray[0];
            $chapterId = $verseAsArray[1];
            $verseId = $verseAsArray[2];

            // more than one separator could appear in verse body
            $verse = '';
            $count = count($verseAsArray);
            for ($i = 3; $i < $count; $i++) {
                $verse .= $verseAsArray[$i];

                if ($i < $count-1) {
                    $verse .= $this->separator;
                }
            }

            if (!isset($translationArray[$bookId])) {
                $translationArray[$bookId] = [];
            }

            if (!isset($translationArray[$bookId][$chapterId])) {
                $translationArray[$bookId][$chapterId] = [];
            }

            if (!isset($translationArray[$bookId][$chapterId][$verseId])) {
                $translationArray[$bookId][$chapterId][$verseId] = trim(str_replace(['\f6 ', '&ndash;', '&mdash;'], ['', '-', '-'], $verse));
            }
        }

        $translation = new Translation($this->getAbout());

        foreach ($translationArray as $bookId => $books) {
            $book = new Book($this->books->convertNameToOneOfTheSupportedBooksId((string) $bookId));

            foreach ($books as $chapterId => $chapters) {
                $chapter = new Chapter($chapterId);

                foreach ($chapters as $verseId => $content) {
                    $chapter->addVerse(new Verse($verseId, $content));
                }

                $book->addChapter($chapter);
            }

            $translation->addBook($book);
        }

        return $translation;
    }

    private function getAbout(): About
    {
        return new About(
            '',
            '',
            '',
            '',
            '',
            '',
            ''
        );
    }
}
