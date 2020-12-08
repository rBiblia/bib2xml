<?php

declare(strict_types=1);

namespace rBibliaBibleConverter\Input;

use rBibliaBibleConverter\Bible\Books;
use rBibliaBibleConverter\Reader\InputReader;
use rBibliaBibleConverter\Text\Sanitizer;
use rBibliaBibleConverter\Value\About;
use rBibliaBibleConverter\Value\Book;
use rBibliaBibleConverter\Value\Chapter;
use rBibliaBibleConverter\Value\Translation;
use rBibliaBibleConverter\Value\Verse;
use SimpleXMLElement;

class ZefaniaInput implements InputConverter
{
    /** @var InputReader */
    private $input;

    /** @var Sanitizer */
    private $sanitizer;

    /** @var Books */
    private $books;

    /** @var SimpleXMLElement */
    private $xml;

    public function __construct(InputReader $input, Sanitizer $sanitizer, Books $books)
    {
        $this->input = $input;
        $this->sanitizer = $sanitizer;
        $this->books = $books;

        $this->xml = simplexml_load_string($input->getContent());
    }

    public function getTranslation(): Translation
    {
        $translation = new Translation($this->getAbout());

        /** @var SimpleXMLElement $bookNode */
        foreach ($this->xml->BIBLEBOOK as $bookNode) {
            $bookName = $bookNode->attributes()['bnumber']->__toString();
            $book = new Book($this->books->convertNameToOneOfTheSupportedBooksId($bookName));

            /** @var SimpleXMLElement $chapterNode */
            foreach ($bookNode->CHAPTER as $chapterNode) {
                $chapterId = (int) $chapterNode->attributes()['cnumber']->__toString();
                $chapter = new Chapter($chapterId);

                /** @var SimpleXMLElement $verseNode */
                foreach ($chapterNode->VERS as $verseNode) {
                    $verseId = (int) $verseNode->attributes()['vnumber']->__toString();
                    $chapter->addVerse(new Verse($verseId, $this->sanitizer->sanitize($verseNode->__toString())));
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
            strtolower($this->getAboutValue('language')),
            $this->getAboutValue('rights'),
            $this->getAboutValue('title'),
            $this->getAboutValue('description'),
            strtoupper($this->getAboutValue('identifier')),
            $this->getAboutValue('date'),
            $this->getAboutValue('coverage')
        );
    }

    private function getAboutValue(string $key): string
    {
        return trim($this->xml->INFORMATION->{$key}->__toString());
    }
}
