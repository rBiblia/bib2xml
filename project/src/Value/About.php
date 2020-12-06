<?php

declare(strict_types=1);

namespace rBibliaBibleConverter\Value;

class About
{
    /** @var string */
    private $language;

    /** @var string */
    private $authorised;

    /** @var string */
    private $name;

    /** @var string */
    private $description;

    /** @var string */
    private $shortname;

    /** @var string */
    private $date;

    /** @var string */
    private $notice;

    public function __construct(
        string $language,
        string $authorised,
        string $name,
        string $description,
        string $shortname,
        string $date,
        string $notice
    ) {
        $this->language = htmlspecialchars($language);
        $this->authorised = htmlspecialchars($authorised);
        $this->name = htmlspecialchars($name);
        $this->description = htmlspecialchars($description);
        $this->shortname = htmlspecialchars($shortname);
        $this->date = htmlspecialchars($date);
        $this->notice = $notice;
    }

    public function getLanguage(): string
    {
        return $this->language;
    }

    public function getAuthorised(): string
    {
        return $this->authorised;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getShortname(): string
    {
        return $this->shortname;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function getNotice(): string
    {
        return $this->notice;
    }
}
