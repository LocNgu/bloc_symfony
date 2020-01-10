<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Post;
use App\Entity\Tag;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class PostFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $cat_coding = $manager->getRepository(Category::class)->findOneBy(['name' => 'Coding']);
        $cat_tech = $manager->getRepository(Category::class)->findOneBy(['name' => 'Tech']);
        $cat_news = $manager->getRepository(Category::class)->findOneBy(['name' => 'News']);

        $tag1 = new Tag('tag1');
        $tag2 = new Tag('tag2');

        $post = new Post();
        $author = $manager->getRepository(User::class)->findOneBy(['username' => 'walterwriter']);
        $post->setAuthor($author);
        $post->setTitle('Hello World');
        $post->setCategory($cat_coding);
        $post->addTag($tag1);
        $post->setPublic(true);
        $post->setPublicationDate(new \DateTime('2020-01-09'));
        $manager->persist($post);

        $post = new Post();
        $author = $manager->getRepository(User::class)->findOneBy(['username' => 'authorarthur']);
        $post->setAuthor($author);
        $post->setTitle('42');
        $post->setCategory($cat_tech);
        $post->addTag($tag2);
        $post->setPublicationDate(new \DateTime('2020-01-09'));
        $post->setPublic(false);
        $manager->persist($post);

        $post = new Post();
        $author = $manager->getRepository(User::class)->findOneBy(['username' => 'authorarthur']);
        $post->setAuthor($author);
        $post->setTitle('1337');
        $post->setCategory($cat_news);
        $post->addTag($tag2);
        $post->addTag($tag1);
        $post->setPublicationDate(new \DateTime('2020-01-09'));
        $post->setPublic(false);
        $manager->persist($post);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            CategoryFixtures::class,
        ];
    }
}
