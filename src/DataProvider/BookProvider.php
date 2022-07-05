<?php
declare(strict_types=1);

namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\Exception\ResourceClassNotSupportedException;
use App\DTO\Book;
use Symfony\Component\Yaml\Yaml;

class BookProvider implements ItemDataProviderInterface, RestrictedDataProviderInterface
{
    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return $resourceClass === Book::class;
    }

    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = [])
    {
        $books = Yaml::parseFile(__DIR__.'/../../var/books.yaml');

        foreach ($books as $bookInfo) {
            if ($bookInfo['id'] === $id) {
                $book = new Book();
                $book->id = intval($bookInfo['id']);
                $book->name = $bookInfo['name'];
                $book->authorName = $bookInfo['author'];
                $book->publishedAt = intval($bookInfo['publishedAt']);

                return $book;
            }
        }

        return null;
    }
}
