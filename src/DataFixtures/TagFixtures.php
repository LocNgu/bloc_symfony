<?php

namespace App\DataFixtures;

use App\Entity\Tag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class TagFixtures extends Fixture
{
    /**
     * Load data fixtures with the passed EntityManager.
     */
    public function load(ObjectManager $manager)
    {
        $tags = ['tech', 'news', 'coding', 'travel'];
        foreach ($tags as $tag) {
            $manager->persist(new Tag($tag));
        }
        $manager->flush();
    }
}
