<?php declare(strict_types=1);

namespace App\Entity;

class Pagination
{
    private int $page;
    private array $items;
    private int $numPages;

    public function getPage(): int
    {
        return $this->page;
    }

    public function setPage(int $page): Pagination
    {
        $this->page = $page;

        return $this;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function setItems(array $items): Pagination
    {
        $this->items = $items;

        return $this;
    }

    public function getNumPages(): int
    {
        return $this->numPages;
    }

    public function setNumPages(int $numPages): Pagination
    {
        $this->numPages = $numPages;

        return $this;
    }
}