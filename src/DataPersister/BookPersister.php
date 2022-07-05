<?php
declare(strict_types=1);

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\DTO\Book;
use Symfony\Component\Yaml\Yaml;

class BookPersister implements DataPersisterInterface
{
    public function supports($data): bool
    {
        return $data instanceof Book;
    }

    public function persist($data)
    {
        assert($data instanceof Book);
        $books = Yaml::parseFile(__DIR__.'/../../var/books.yaml');
        $keyToWrite = null;
        $maxId = 0;
        foreach ($books as $key => $book) {
            $maxId = max($maxId, intval($book['id']));
            if ($data->id === $book['id']) {
                $keyToWrite = $key;
            }
        }
        if (null === $keyToWrite) {
            $keyToWrite = 'book'.date('YmdHis');
            $books[$keyToWrite] = [
                'id' => $maxId + 1,
            ];
        }
        $books[$keyToWrite]['name'] = $data->name;
        $books[$keyToWrite]['author'] = $data->authorName;
        $books[$keyToWrite]['publishedAt'] = $data->publishedAt;

        file_put_contents(__DIR__.'/../../var/books.yaml', Yaml::dump($books));
    }

    public function remove($data)
    {
        assert($data instanceof Book);
        $books = Yaml::parseFile(__DIR__.'/../../var/books.yaml');
        foreach ($books as $key => $book) {
            if ($data->id === $book['id']) {
                unset($books[$key]);
            }
        }

        file_put_contents(__DIR__.'/../../var/books.yaml', Yaml::dump($books));
    }

}
