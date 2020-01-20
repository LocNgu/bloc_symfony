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

        $tag1 = $manager->getRepository(Tag::class)->findOneBy(['name' => 'coding']);
        $tag2 = $manager->getRepository(Tag::class)->findOneBy(['name' => 'c++']);
        $tag3 = $manager->getRepository(Tag::class)->findOneBy(['name' => 'symfony']);
        $tag4 = $manager->getRepository(Tag::class)->findOneBy(['name' => 'tech']);
        $tag5 = $manager->getRepository(Tag::class)->findOneBy(['name' => 'news']);



        $post = new Post();
        $author = $manager->getRepository(User::class)->findOneBy(['username' => 'walterwriter']);
        $post->setAuthor($author);
        $post->setTitle('Hello World');
        $post->setCategory($cat_coding);
        $post->setPublic(true);
        $post->setPublicationDate(new \DateTime('2020-01-09'));
        $post->addTag($tag1);
        $post->addTag($tag5);
        $post->setPreviewImg('./img/1.jpg');
        $manager->persist($post);

        $post = new Post();
        $author = $manager->getRepository(User::class)->findOneBy(['username' => 'authorarthur']);
        $post->setAuthor($author);
        $post->setTitle('Lorem ipsum dolor');
        $post->setCategory($cat_tech);
        $post->setPublicationDate(new \DateTime('2020-01-09'));
        $post->setPublic(true);
        $post->addTag($tag1);
        $post->addTag($tag2);
        $post->setPreviewImg('./img/2.jpg');
        $manager->persist($post);

        $post = new Post();
        $author = $manager->getRepository(User::class)->findOneBy(['username' => 'authorarthur']);
        $post->setAuthor($author);
        $post->setTitle('uisquam est');
        $post->setCategory($cat_news);
        $post->setPublicationDate(new \DateTime('2020-01-09'));
        $post->setPublic(true);
        $post->addTag($tag2);
        $post->addTag($tag3);
        $post->addTag($tag4);
        $post->setPreviewImg('./img/3.jpg');
        $manager->persist($post);

        $post = new Post();
        $author = $manager->getRepository(User::class)->findOneBy(['username' => 'walterwriter']);
        $post->setAuthor($author);
        $post->setTitle('sanctus');
        $post->setCategory($cat_coding);
        $post->setPublic(true);
        $post->setPublicationDate(new \DateTime('2019-01-09'));
        $post->addTag($tag1);
        $post->addTag($tag5);
        $post->setPreviewImg('./img/4.jpg');
        $manager->persist($post);

        $post = new Post();
        $author = $manager->getRepository(User::class)->findOneBy(['username' => 'authorarthur']);
        $post->setAuthor($author);
        $post->setTitle('voluptua');
        $post->setCategory($cat_tech);
        $post->setPublicationDate(new \DateTime('2020-01-01'));
        $post->setPublic(true);
        $post->addTag($tag1);
        $post->addTag($tag2);
        $post->setPreviewImg('./img/5.jpg');
        $manager->persist($post);

        $post = new Post();
        $author = $manager->getRepository(User::class)->findOneBy(['username' => 'authorarthur']);
        $post->setAuthor($author);
        $post->setTitle('Stet clita');
        $post->setCategory($cat_news);
        $post->setPublicationDate(new \DateTime('2020-01-15'));
        $post->setPublic(true);
        $post->addTag($tag2);
        $post->addTag($tag3);
        $post->addTag($tag4);
        $post->setPreviewImg('./img/6.jpg');
        $manager->persist($post);
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            CategoryFixtures::class,
            TagFixtures::class,
        ];
    }
}
