<?php

declare(strict_types=1);

namespace rBibliaBibleConverter\Output;

use rBibliaBibleConverter\Value\Book;
use rBibliaBibleConverter\Value\Chapter;
use rBibliaBibleConverter\Value\Translation;
use rBibliaBibleConverter\Value\Verse;
use rBibliaBibleConverter\Xml\SimpleXMLExtended;

class XmlOutput implements OutputConverter
{
    /** @var Translation */
    private $translation;

    public function __construct(Translation $translation)
    {
        $this->translation = $translation;
    }

    public function getContent(): string
    {
        $xml = new SimpleXMLExtended('<?xml version="1.0" encoding="utf-8" ?><bibx></bibx>');

        $aboutNode = $xml->addChild('about');
        $aboutNode->addChild('language', $this->translation->getAbout()->getLanguage());
        $aboutNode->addChild('authorised', $this->translation->getAbout()->getAuthorised());
        $aboutNode->addChild('name', $this->translation->getAbout()->getName());
        $aboutNode->addChild('description', $this->translation->getAbout()->getDescription());
        $aboutNode->addChild('shortname', $this->translation->getAbout()->getShortname());
        $aboutNode->addChild('date', $this->translation->getAbout()->getDate());

        if ($this->translation->getAbout()->getNotice() !== '') {
            $xml->about->notice = null;
            $xml->about->notice->addCData($this->translation->getAbout()->getNotice());
        }

        $translation = $xml->addChild('translation');
        /** @var Book $book */
        foreach ($this->translation->getBooks() as $book) {
            $bookNode = $translation->addChild('book');
            $bookNode->addAttribute('id', $book->getId());

            /** @var Chapter $chapter */
            foreach ($book->getChapters() as $chapter) {
                $chapterNode = $bookNode->addChild('chapter');
                $chapterNode->addAttribute('id', (string) $chapter->getId());

                /** @var Verse $verse */
                foreach ($chapter->getVerses() as $verse) {
                    $verseNode = $chapterNode->addChild('verse', $verse->getContent());
                    $verseNode->addAttribute('id', (string) $verse->getId());
                }
            }
        }

        $dom = dom_import_simplexml($xml)->ownerDocument;
        $dom->formatOutput = true;
        $output = $dom->saveXML();

        return str_replace('  ', "\t", $output);
    }
}
