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

class WordInput implements InputConverter
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
        $translation = new Translation($this->getAbout());

        $contentAsArray = explode(PHP_EOL, $this->input->getContent());
        $groupType = $this->getInputType($this->input->getOriginalInput());
        $contentIndex = -1;

        foreach ($this->books::ALIASES as $bookId => $alias) {
            if (!isset($alias['group'])) {
                continue;
            }

            if (\in_array($alias['group'], $groupType, true)) {
                $book = new Book($bookId);

                for ($chapterId = 1; $chapterId <= \count($alias['chapters']); ++$chapterId) {
                    $chapter = new Chapter($chapterId);

                    for ($verseId = 1; $verseId <= $alias['chapters'][$chapterId]; ++$verseId) {
                        ++$contentIndex;

                        if (!isset($contentAsArray[$contentIndex])) {
                            continue;
                        }

                        $sanitizedScripture = $this->sanitizer->sanitize($contentAsArray[$contentIndex]);

                        if (empty($sanitizedScripture)) {
                            continue;
                        }

                        $chapter->addVerse(new Verse($verseId, $sanitizedScripture));
                    }

                    if (0 === \count($chapter->getVerses())) {
                        continue;
                    }

                    $isChapterEmpty = true;

                    /** @var Verse $chapterVerse */
                    foreach ($chapter->getVerses() as $chapterVerse) {
                        if (!empty($chapterVerse->getContent())) {
                            $isChapterEmpty = false;
                        }
                    }

                    if ($isChapterEmpty) {
                        continue;
                    }

                    $book->addChapter($chapter);
                }

                if (0 === \count($book->getChapters())) {
                    continue;
                }

                $translation->addBook($book);
            }
        }

        return $translation;
    }

    private function getInputType(string $fileName): array
    {
        $results = [];

        $group = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if (Books::GROUP_OT !== $group && Books::GROUP_NT !== $group) {
            $results[] = Books::GROUP_NT;
            $results[] = Books::GROUP_OT;

            return $results;
        }

        $results[] = $group;

        return $results;
    }

    private function getAbout(): About
    {
        $name = '';
        preg_match('/short.title=(.*)/i', $this->input->getContent(), $matches);
        if (!empty($matches)) {
            $name = trim($matches[1]);
        }

        $description = '';
        preg_match('/description=(.*)/i', $this->input->getContent(), $matches);
        if (!empty($matches)) {
            $description = trim($matches[1]);
        }

        return new About('', '', $name, $description, '', '', '');
    }
}
