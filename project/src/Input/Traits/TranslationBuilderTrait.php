<?php

declare(strict_types=1);

namespace rBibliaBibleConverter\Input\Traits;

use PDO;
use rBibliaBibleConverter\Bible\Books;
use rBibliaBibleConverter\Reader\InputReader;
use rBibliaBibleConverter\Text\Sanitizer;
use rBibliaBibleConverter\Value\Book;
use rBibliaBibleConverter\Value\Chapter;
use rBibliaBibleConverter\Value\Translation;
use rBibliaBibleConverter\Value\Verse;

trait TranslationBuilderTrait
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

    private function buildTranslationFromTree(Translation $translation, array $rawData = []): Translation
    {
        foreach ($rawData as $bookId => $chapters) {
            $book = new Book($this->books->convertNameToOneOfTheSupportedBooksId((string) $bookId));

            foreach ($chapters as $chapterId => $verses) {
                $chapter = new Chapter($chapterId);

                foreach ($verses as $verseId => $scripture) {
                    $sanitizedScripture = $this->sanitizer->sanitize((string) $scripture);

                    $chapter->addVerse(new Verse((int) $verseId, $sanitizedScripture));
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
}
