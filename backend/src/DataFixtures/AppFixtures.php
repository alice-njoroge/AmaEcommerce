<?php

namespace App\DataFixtures;

use App\Entity\Product;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $product = new Product();
        $product->setName("Plain Old Pineapple");
        $product->setQuantity(10);
        $product->setImageURL("plain-old-pineapple.jpg");
        $product->setCreatedAt(new DateTimeImmutable());
        $product->setUpdatedAt(new DateTimeImmutable());
        $product->setStatus(true);
        $manager->persist($product);

        $manager->flush();
    }
}
