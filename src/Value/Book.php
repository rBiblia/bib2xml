<?php

declare(strict_types=1);

namespace rBibliaBibleConverter\Value;

class Book
{
    /** @var array */
    private $chapters = [];

    /** @var string */
    private $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function addChapter(Chapter $chapter): self
    {
        $this->chapters[$chapter->getId()] = $chapter;

        return $this;
    }

    public function getChapters(): array
    {
        return $this->chapters;
    }
}
