<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $categories = ['Tech', 'Travel', 'Coding', 'News'];
        foreach ($categories as $category) {
            $manager->persist(new Category($category));
        }
        $manager->flush();
    }
}
