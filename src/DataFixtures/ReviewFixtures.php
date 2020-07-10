<?php

namespace App\DataFixtures;

use App\Entity\Review;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Id\AssignedGenerator;
use Doctrine\ORM\Mapping\ClassMetadata;
use Faker\Factory;
use Ramsey\Uuid\Uuid;

class ReviewFixtures extends Fixture implements FixtureGroupInterface
{
    public static $uuids = [
        '90bee04e-445c-405a-ba9d-b3a0fcccb7f4',
        'd177b538-695b-4ccb-855e-4b90407a1933',
        '8ed6f037-24ef-4b29-9173-06bf24c3cb0c',
        'db004667-fb66-45bc-ab31-137f49981972',
        'e9673d6a-5747-4c9d-880d-e1169011eeb9',
        '7a007d21-f599-4e15-8891-bf3ec629a212',
        'd7a6fba6-6997-4228-ab92-947c1b9b6f6c',
        'fde89414-c314-4b11-986e-718fcbb4f2d0',
        '006d4990-b6b8-42dc-82c1-835513a6fccc',
        'fb5a885f-f7e8-4a50-950f-c1a64a94d500',
    ];

    public function load(ObjectManager $manager)
    {
        $metadata = $manager->getClassMetadata(Review::class);
        $metadata->setIdGenerator(new AssignedGenerator());
        $metadata->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_NONE);

        $faker = Factory::create();

        foreach (self::$uuids as $uuid) {
            $review = new Review();
            $review->id = Uuid::fromString($uuid);
            $review->body = $faker->paragraph;
            $review->rating = $faker->numberBetween(0, 5);
            $review->author = $faker->name;
            $review->publicationDate = $faker->dateTime;
            $manager->persist($review);

            $this->addReference($uuid, $review);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['Book Fixtures Loaded'];
    }
}
