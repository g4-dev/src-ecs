<?php


namespace Admin\Entity;

use Core\Entity as CoreEn;
use Core\Entity\Admin;
use Core\Entity\Model\Sluggable;
use Core\Entity\Traits\Id;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Article
 *
 * @ORM\MappedSuperclass
 * @ORM\Table(name="cms_diy")
 * @ORM\Entity(repositoryClass="Admin\Repository\DiyRepository")
 * @ORM\HasLifecycleCallbacks
 * @Vich\Uploadable
 */
class Diy extends AbstractSluggable
{
    use Id;
    // Name == title
    use CoreEn\Traits\DatesAt;
    use CoreEn\Traits\IsActive;
    use CoreEn\Traits\ImageCollection;
    use CoreEn\Traits\Name;
    
    /**
     * @ORM\Column(type="text")
     */
    private $body;
    
    /**
     * @ORM\Column(type="text")
     */
    private $summary;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $difficulty;
    
    /**
     * List of tags associated to the product.
     *
     * @var string[]
     * @ORM\Column(type="simple_array")
     */
    private $ingredients = array();
    
    /**
     * @var CoreEn\Admin
     *
     * @ORM\ManyToOne(targetEntity="Core\Entity\Admin")
     * @ORM\JoinColumn(nullable=true)
     */
    private $author;
    
    /**
     * @ORM\Column(type="string")
     */
    private $time;
    
    /**
     * @ORM\Column(type="boolean", options={"default": false})
     */
    private $onHome = false;
    
    /**
     * It only stores the name of the image associated with the product.
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $image;
    
    /**
     * This unmapped property stores the binary contents of the image file
     * associated with the product.
     *
     * @Vich\UploadableField(mapping="blog_covers", fileNameProperty="image")
     *
     * @var File
     */
    private $imageFile;
    
    public function __construct()
    {
        if (method_exists($this, '_init')) {
            $this->_init();
        }
    }
    
    public function getBody(): ?string
    {
        return $this->body;
    }
    
    public function setBody(string $body): self
    {
        $this->body = $body;
        return $this;
    }
    
    public function getAuthor(): ?CoreEn\Admin
    {
        return $this->author;
    }
    
    public function setAuthor(?CoreEn\Admin $author): self
    {
        $this->author = $author;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getImage(): ?string
    {
        return $this->image;
    }
    
    /**
     * @param string $image
     * @return CmsPage
     */
    public function setImage(?string $image): self
    {
        $this->image = $image;
        
        return $this;
    }
    
    /**
     * @return File
     */
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }
    
    /**
     * @param File $imageFile
     * @return CmsPage
     */
    public function setImageFile(?File $imageFile): self
    {
        $this->imageFile = $imageFile;
        
        return $this;
    }

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(string $summary): self
    {
        $this->summary = $summary;

        return $this;
    }

    public function getDifficulty(): ?int
    {
        return $this->difficulty;
    }

    public function setDifficulty(int $difficulty): self
    {
        $this->difficulty = $difficulty;

        return $this;
    }

    public function getTime(): ?string
    {
        return $this->time;
    }

    public function setTime(string $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function getOnHome(): ?bool
    {
        return $this->onHome;
    }

    public function setOnHome(bool $onHome): self
    {
        $this->onHome = $onHome;

        return $this;
    }

    public function getIngredients(): ?array
    {
        return $this->ingredients;
    }

    public function setIngredients(array $ingredients): self
    {
        $this->ingredients = $ingredients;

        return $this;
    }
}