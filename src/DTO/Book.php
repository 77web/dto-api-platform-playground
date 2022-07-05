<?php
declare(strict_types=1);

namespace App\DTO;

class Book
{
    public string|null $name = null;
    public string|null $authorName = null;
    public int|null $publishedAt = null;
}
