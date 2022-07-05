<?php
declare(strict_types=1);

namespace App\DTO;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;

#[ApiResource]
class Book
{
    #[ApiProperty(identifier: true)]
    public int|null $id = null;
    public string|null $name = null;
    public string|null $authorName = null;
    public int|null $publishedAt = null;
}
