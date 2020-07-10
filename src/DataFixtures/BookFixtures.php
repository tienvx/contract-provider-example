<?php

namespace App\DataFixtures;

use App\Entity\Book;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Id\AssignedGenerator;
use Doctrine\ORM\Mapping\ClassMetadata;
use Faker\Factory;
use Ramsey\Uuid\Uuid;

class BookFixtures extends Fixture implements FixtureGroupInterface
{
    public static $uuids = [
        '1065838a-1ba3-4469-bfa5-96ad7b720df5',
        '064024bd-c301-41c6-8567-6164e3eaba80',
        '3bd2ea9c-e77b-4e5e-9f36-3bd84f1b27b7',
        'e956baac-814b-4ea4-9503-f3bf2c2b92a1',
        'ea3318b4-4679-4105-a68f-62eec8230e9a',
        'c309917f-4f21-479e-bc6d-6e29e8ad71e7',
        '04eb2d56-b240-4cec-b48f-83b7276d6e3e',
        '0114b2a8-3347-49d8-ad99-0e792c5a30e6',
    ];

    public function load(ObjectManager $manager)
    {
        $metadata = $manager->getClassMetadata(Book::class);
        $metadata->setIdGenerator(new AssignedGenerator());
        $metadata->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_NONE);

        $faker = Factory::create();

        foreach (self::$uuids as $uuid) {
            $book = new Book();
            $book->id = Uuid::fromString($uuid);
            $book->isbn = $faker->isbn13;
            $book->title = $faker->sentence;
            $book->description = $faker->paragraph;
            $book->author = $faker->name;
            $book->publicationDate = $faker->dateTime;
            $manager->persist($book);

            $this->addReference($uuid, $book);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['Book Fixtures Loaded'];
    }
}
