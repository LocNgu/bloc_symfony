<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\ManyToMany;

/**
 * Post.
 *
 * @ORM\Entity(repositoryClass="App\Repository\PostRepository")
 * @ORM\Table(name="post")
 */
class Post
{
    public function __construct()
    {
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(
     *   type="datetime",
     *   nullable=true
     * )
     */
    private $publicationDate;

    /**
     * @ORM\Column(
     *   type="string",
     *   nullable=true
     * )
     */
    private $title;

    /**
     * @ORM\Column(
     *   type="string",
     *   nullable=true
     * )
     */
    private $previewImg;

    /**
     * @ORM\Column(
     *   type="text",
     *   nullable=true
     * )
     */
    private $summary;

    /**
     * @ORM\Column(
     *   type="text",
     *   nullable=true
     * )
     */
    private $content;

    /**
     * @ORM\Column(
     *   type="boolean",
     *   options={
     *       "default":false
     *   },
     *   nullable=false
     * )
     */
    private $public;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="author_id", referencedColumnName="id")
     */
    private $author;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="posts")
     */
    private $category;

    /**
     * @ManyToMany(targetEntity="Tag", inversedBy="posts")
     * @JoinTable(name="posts_tags")
     */
    private $tags = [];

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set publicationDate.
     *
     * @param \DateTime|null $publicationDate
     *
     * @return Post
     */
    public function setPublicationDate($publicationDate = null)
    {
        $this->publicationDate = $publicationDate;

        return $this;
    }

    /**
     * Get publicationDate.
     *
     * @return \DateTime|null
     */
    public function getPublicationDate()
    {
        return $this->publicationDate;
    }

    /**
     * Set title.
     *
     * @param string|null $title
     *
     * @return Post
     */
    public function setTitle($title = null)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title.
     *
     * @return string|null
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set previewImg.
     *
     * @param string|null $previewImg
     *
     * @return Post
     */
    public function setPreviewImg($previewImg = null)
    {
        $this->previewImg = $previewImg;

        return $this;
    }

    /**
     * Get previewImg.
     *
     * @return string|null
     */
    public function getPreviewImg()
    {
        return $this->previewImg;
    }

    /**
     * Set summary.
     *
     * @param string|null $summary
     *
     * @return Post
     */
    public function setSummary($summary = null)
    {
        $this->summary = $summary;

        return $this;
    }

    /**
     * Get summary.
     *
     * @return string|null
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * Set content.
     *
     * @param string|null $content
     *
     * @return Post
     */
    public function setContent($content = null)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content.
     *
     * @return string|null
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set public.
     *
     * @param bool|null $public
     *
     * @return Post
     */
    public function setPublic($public = false)
    {
        $this->public = $public;

        return $this;
    }

    /**
     * Get public.
     */
    public function getPublic(): ?bool
    {
        return $this->public;
    }

    /**
     * Set author.
     *
     * @param User $author
     * @return Post
     */
    public function setAuthor(User $author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author.
     *
     * @return User|null
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set category.
     *
     * @param Category|null $category
     * @return Post
     */
    public function setCategory(Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category.
     *
     * @return Category|null
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Add tag.
     *
     * @param Tag $tag
     * @return Post
     */
    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
            $tag->addPost($this); // synchronously updating inverse side
        }

        return $this;
    }

    /**
     * Remove tag.
     *
     * @param Tag $tag
     * @return Post TRUE if this collection contained the specified element, FALSE otherwise
     */
    public function removeTag(Tag $tag): self
    {
        if ($this->tags->contains($tag)) {
            $this->tags->removeElement($tag);
            $tag->removePost($this);
        }

        return $this;
    }

    /**
     * Get tags.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTags()
    {
        return $this->tags;
    }
}
