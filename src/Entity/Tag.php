<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Tag.
 *
 * @ORM\Entity(repositoryClass="App\Repository\TagRepository")
 * @ORM\Table(name="tag")
 * @UniqueEntity(
 *     "name",
 *     message="Tag already exist")
 */
class Tag
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->posts = new ArrayCollection();
    }

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank(message="Name should not be blank.")
     * @Assert\Unique
     * @ORM\Column(name="name", type="string", length=45, nullable=false, unique=true))
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="Post", mappedBy="tags")
     */
    private $posts;

    /**
     * Get tagId.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Tag
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    public function addPost(Post $post): self
    {
        if (!$this->posts->contains($post)) {
        $this->posts[] = $post;
//            $post->addTag($this);
    }
        return $this;
    }

    /**
     * Remove post.
     *
     * @param Post $post
     * @return Tag TRUE if this collection contained the specified element, FALSE otherwise
     */
    public function removePost(Post $post): self
    {
        if ($this->posts->contains($post)) {
            $this->posts->removeElement($post);
            $post->removeTag($this);
        }

        return $this;
    }

    /**
     * Get posts.
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
