<?php

declare(strict_types=1);

namespace rBibliaBibleConverter\Input;

use PDO;
use rBibliaBibleConverter\Input\Traits\TranslationBuilderTrait;
use rBibliaBibleConverter\Value\About;
use rBibliaBibleConverter\Value\Translation;

class MybibleInput implements InputConverter
{
    use TranslationBuilderTrait;

    public function getTranslation(): Translation
    {
        return $this->buildTranslationFromTree(
            new Translation($this->getAbout()),
            $this->getAll($this->getBooks())
        );
    }

    private function getAbout(): About
    {
        $description = '';
        $language = '';

        $stmt = $this->pdo->query('SELECT * FROM info', PDO::FETCH_ASSOC);

        foreach ($stmt as $row) {
            if ('description' === $row['name']) {
                $description = $row['value'];
            }

            if ('language' === $row['name']) {
                $language = strtolower($row['value']);
            }
        }

        return new About($language, '', $description, '', '', '', '');
    }

    private function getBooks(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM books', PDO::FETCH_ASSOC);

        $results = [];
        foreach ($stmt as $row) {
            $bookNumber = $row['book_number'];
            $shortName = $row['short_name'];

            $results[$bookNumber] = $shortName;
        }

        return $results;
    }

    private function getAll(array $books = []): array
    {
        $stmt = $this->pdo->query('SELECT * FROM verses ORDER BY book_number ASC, chapter ASC, verse ASC', PDO::FETCH_ASSOC);

        $results = [];
        foreach ($stmt as $row) {
            $bookId = $books[$row['book_number']];
            $chapterId = $row['chapter'];
            $verseId = $row['verse'];
            $content = $row['text'];

            $results[$bookId][$chapterId][$verseId] = $content;
        }

        return $results;
    }
}
