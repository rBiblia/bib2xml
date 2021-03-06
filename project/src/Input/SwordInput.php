<?php

declare(strict_types=1);

namespace rBibliaBibleConverter\Input;

use PDO;
use rBibliaBibleConverter\Bible\Books;
use rBibliaBibleConverter\Reader\InputReader;
use rBibliaBibleConverter\Text\Sanitizer;
use rBibliaBibleConverter\Value\About;
use rBibliaBibleConverter\Value\Book;
use rBibliaBibleConverter\Value\Chapter;
use rBibliaBibleConverter\Value\Translation;
use rBibliaBibleConverter\Value\Verse;

class SwordInput implements InputConverter
{
    /** @var InputReader */
    private $input;

    /** @var Sanitizer */
    private $sanitizer;

    /** @var PDO */
    private $pdo;

    /** @var Books */
    private $books;

    public function __construct(InputReader $input, Sanitizer $sanitizer, Books $books)
    {
        $this->input = $input;
        $this->sanitizer = $sanitizer;
        $this->books = $books;

        $this->pdo = new PDO(sprintf('sqlite:%s', $input->getOriginalInput()));
    }

    public function getTranslation(): Translation
    {
        $translation = new Translation($this->getAbout());
        $raw = $this->getAll();

        foreach ($raw as $bookId => $chapters) {
            $book = new Book($this->books->convertNameToOneOfTheSupportedBooksId((string) $bookId));

            foreach ($chapters as $chapterId => $verses) {
                $chapter = new Chapter($chapterId);

                foreach ($verses as $verseId => $scripture) {
                    $sanitizedScripture = $this->sanitizer->sanitize($scripture);

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

        return $translation;
    }

    private function getAbout(): About
    {
        $stmt = $this->pdo->query('SELECT * FROM Details LIMIT 1', PDO::FETCH_ASSOC);

        $about = new About('', '', '', '', '', '', '');
        foreach ($stmt as $row) {
            $notice = str_replace([
                '{\b ',
                '}',
                '\par',
            ], [
                '',
                '',
                '<br>',
            ], $row['Comments']);

            $about = new About('', '', $row['Description'], '', strtoupper($row['Abbreviation']), '', $notice);
        }

        return $about;
    }

    private function getAll(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM Bible ORDER BY Book ASC, Chapter ASC, Verse ASC', PDO::FETCH_ASSOC);

        $results = [];
        foreach ($stmt as $row) {
            $bookId = $row['Book'];
            $chapterId = $row['Chapter'];
            $verseId = $row['Verse'];
            $content = $row['Scripture'];

            $results[$bookId][$chapterId][$verseId] = $content;
        }

        return $results;
    }
}
