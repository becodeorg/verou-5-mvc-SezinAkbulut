<?php

declare(strict_types=1);

class Article
{
    public int $id;
    public ?string $photo;

    public string $title;
    public ?string $description;
    public ?string $publishDate;
    public string $author;

    public function __construct(?int $id, ?string $photo, string $title, ?string $description, ?string $publishDate, string $author)
    {
        $this->id = $id;
        $this->photo = $photo;
        $this->title = $title;
        $this->description = $description;
        $this->publishDate = $publishDate;
        $this->author = $author;
    }

    public function formatPublishDate($format = 'd-m-Y')
    {
        if ($this->publishDate !== null) {
            $dateTime = new DateTime($this->publishDate);

            return $dateTime->format($format);
        }

        return '';
    }
}



