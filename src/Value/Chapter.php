<?php

declare(strict_types=1);

namespace rBibliaBibleConverter\Value;

class Chapter
{
    /** @var array */
    private $verses = [];

    /** @var int */
    private $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function addVerse(Verse $verse): self
    {
        $this->verses[$verse->getId()] = $verse;

        return $this;
    }

    public function getVerses(): array
    {
        return $this->verses;
    }
}
