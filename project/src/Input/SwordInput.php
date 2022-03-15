<?php

declare(strict_types=1);

namespace rBibliaBibleConverter\Input;

use PDO;
use rBibliaBibleConverter\Input\Traits\TranslationBuilderTrait;
use rBibliaBibleConverter\Value\About;
use rBibliaBibleConverter\Value\Translation;

class SwordInput implements InputConverter
{
    use TranslationBuilderTrait;

    public function getTranslation(): Translation
    {
        return $this->buildTranslationFromTree(
            new Translation($this->getAbout()),
            $this->getAll()
        );
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
