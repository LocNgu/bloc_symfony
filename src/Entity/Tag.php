<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * Tag
 *
 * @ORM\Entity
 * @ORM\Table(name="tag")
 */

class Tag
{
    /**
     * Constructor
     */
    public function __construct($name)
    {
        $this->name = $name;

        $this->posts = new \Doctrine\Common\Collections\ArrayCollection();

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
     *
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

    public function addPost(Post $post)
    {
        $this->posts[] = $post;
    }

    /**
     * Remove post.
     *
     * @param \Post $post
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removePost(\Post $post)
    {
        return $this->posts->removeElement($post);
    }

    /**
     * Get posts.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPosts()
    {
        return $this->posts;
    }
}
