<?php

declare(strict_types=1);

namespace rBibliaBibleConverter\Value;

class Verse
{
    /** @var string */
    private $content;

    /** @var int */
    private $id;

    public function __construct(int $id, string $content)
    {
        $this->id = $id;
        $this->content = $content;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getContent(): string
    {
        return $this->content;
    }
}
