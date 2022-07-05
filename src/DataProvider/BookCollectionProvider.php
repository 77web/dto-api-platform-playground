<?php
declare(strict_types=1);

namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\Exception\ResourceClassNotSupportedException;
use App\DTO\Book;
use Symfony\Component\Yaml\Yaml;

class BookCollectionProvider implements CollectionDataProviderInterface, RestrictedDataProviderInterface
{
    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return $resourceClass === Book::class;
    }

    /**
     * @return iterable<Book>
     */
    public function getCollection(string $resourceClass, string $operationName = null): iterable
    {
        $books = Yaml::parseFile(__DIR__.'/../../var/books.yaml');

        foreach ($books as $bookInfo) {
            $book = new Book();
            $book->id = intval($bookInfo['id']);
            $book->name = $bookInfo['name'];
            $book->authorName = $bookInfo['author'];
            $book->publishedAt = intval($bookInfo['publishedAt']);

            yield $book;
        }
    }
}
