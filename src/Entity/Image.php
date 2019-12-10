<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * Image
 *
 * @ORM\Entity
 * @ORM\Table(name="image")
 */

class Image
{
    public function __construct($title, $description, $imgPath){
        $this->title = $title;
        $this->description = $description;
        $this->imgPath = $imgPath;
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
     * @var string|null
     *
     * @ORM\Column(name="img_path", type="string", length=255, nullable=true)
     */
    private $imgPath;

    /**
     * @var string|null
     *
     * @ORM\Column(name="title", type="string", length=45, nullable=true)
     */
    private $title;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=true)
     */
    private $description;


    /**
     * Get imageId.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set imgPath.
     *
     * @param string|null $imgPath
     *
     * @return Image
     */
    public function setImgPath($imgPath = null)
    {
        $this->imgPath = $imgPath;

        return $this;
    }

    /**
     * Get imgPath.
     *
     * @return string|null
     */
    public function getImgPath()
    {
        return $this->imgPath;
    }

    /**
     * Set title.
     *
     * @param string|null $title
     *
     * @return Image
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
     * Set description.
     *
     * @param string|null $description
     *
     * @return Image
     */
    public function setDescription($description = null)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string|null
     */
    public function getDescription()
    {
        return $this->description;
    }

}
