<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $generator = Factory::create('en_EN');
        $names = ['Plain Old Pineapple', 'Dried Pineapple', 'Pineapple Gum', 'Pineapple Tshirt'];

        $images = array_map(
            function ($name) {
                return strtolower(str_replace(' ', '-', $name)).'.jpg';
            },
            $names
        );

        for ($i = 0; $i < 4; ++$i) {
            $product = new Product();

            $product->setName($generator->randomElement($names));
            $product->setQuantity($generator->numberBetween(1, 20));
            $product->setImageURL($generator->randomElement($images));
            $product->setCreatedAt(new \DateTimeImmutable());
            $product->setUpdatedAt(new \DateTimeImmutable());
            $product->setStatus($generator->boolean());
            $product->setPrice($generator->randomFloat(2, 5, 100));
            $manager->persist($product);
        }

        $manager->flush();
    }
}
