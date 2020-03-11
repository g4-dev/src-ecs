<?php


namespace Admin\Entity;

use Core\Entity as CoreEn;
use Core\Entity\Admin;
use Core\Entity\Model\Sluggable;
use Core\Entity\Traits\Id;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * CmsPage
 * @ORM\MappedSuperclass
 * @ORM\Table(name="cms_page")
 * @ORM\Entity(repositoryClass="Admin\Repository\CmsPageRepository")
 * @ORM\HasLifecycleCallbacks
 * @Vich\Uploadable
 */
class CmsPage extends AbstractSluggable
{
    use Id;
    use CoreEn\Traits\DatesAt;
    use CoreEn\Traits\IsActive;
    use CoreEn\Traits\ImageCollection;
    
    /**
     * @ORM\Column(type="text")
     */
    private $body;
    
    /**
     * @ORM\ManyToOne(targetEntity="Core\Entity\Admin")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="admin_id", referencedColumnName="id")
     * })
     */
    private $author;
    
    /**
     * @var string
     *
     * @ORM\Column(type="text", options={"default": "1-col"})
     */
    private $layout = '1-col';
    
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
    
    /**
     * List of categories where the page is
     *
     * @var CmsCategory[]
     * @ORM\ManyToMany(targetEntity="CmsCategory", inversedBy="items")
     * @ORM\JoinTable(name="cms_categories")
     */
    private $category;
    
    /**
     * @ORM\Column(type="boolean", options={"default": false})
     */
    private $onHome = false;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;
    
    public function __construct()
    {
        if (method_exists($this, '_init')) {
            $this->_init();
        }
        
       $this->category = new ArrayCollection();
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
    
    public function getImage(): ?string
    {
        return $this->image;
    }
    
    public function setImage(?string $image): self
    {
        $this->image = $image;
        
        return $this;
    }
    
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }
    
    public function setImageFile(?File $imageFile): self
    {
        $this->imageFile = $imageFile;
        
        return $this;
    }

    public function getCategory(): Collection
    {
        return $this->category;
    }

    public function setCategory(?array $cmsCat)
    {
        // This is the owning side, we have to call remove and add to have change in the category side too.
       $this->category->clear();
       $this->category = new ArrayCollection($cmsCat);
        
       return $this;
    }

    public function addCategory(CmsCategory $category)
    {
        if ($this->category->contains($category)) {
            return;
        }
        
        $this->category->add($category);
        $category->addItem($this);
    }

    public function removeCategory(CmsCategory $category)
    {
        if (!$this->category->contains($category)) {
            return;
        }
        
        $this->category->removeElement($category);
        $category->addItem($this);
    }
    
    public function __toString(): string
    {
        return (string) $this->getName();
    }

    public function getLayout(): ?string
    {
        return $this->layout;
    }

    public function setLayout(string $layout): self
    {
        $this->layout = $layout;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }
}