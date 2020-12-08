<?php

declare(strict_types=1);

namespace rBibliaBibleConverter\Value;

use rBibliaBibleConverter\Bible\Books;

class Translation
{
    /** @var array */
    private $books = [];

    /** @var About */
    private $about;

    public function __construct(About $about)
    {
        $this->about = $about;
    }

    public function getAbout(): About
    {
        return $this->about;
    }

    public function addBook(Book $book): self
    {
        $this->books[$book->getId()] = $book;

        return $this;
    }

    public function getBooks(): array
    {
        return $this->books;
    }

    public function sort(): void
    {
        $sortedBooks = [];

        foreach (Books::ALIASES as $aliases) {
            foreach ($this->books as $bookId => $book) {
                if (\in_array($bookId, $aliases, true)) {
                    $sortedBooks[$bookId] = $book;

                    break;
                }
            }
        }

        $this->books = $sortedBooks;
    }
}
