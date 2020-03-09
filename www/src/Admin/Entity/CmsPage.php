<?php


namespace Admin\Entity;

use Core\Entity as CoreEn;
use Core\Entity\Admin;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * CmsPage
 *
 * @ORM\Table(name="cms_page", indexes={@ORM\Index(name="index_cms_page_id", columns={"id","name"})})
 * @ORM\Entity(repositoryClass="Admin\Repository\CmsPageRepository")
 * @ORM\HasLifecycleCallbacks
 * @Vich\Uploadable
 *
 */
class CmsPage implements CoreEn\Model\Sluggable
{
    use CoreEn\Traits\Id;
    use CoreEn\Traits\Name;
    use CoreEn\Traits\Slug;
    use CoreEn\Traits\DatesAt;
    use CoreEn\Traits\IsActive;
    
    /**
     * @ORM\Column(type="text")
     */
    private $body;
    
    /**
     * @var CoreEn\Admin
     *
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
     * @ORM\ManyToMany(targetEntity="CmsCategory", inversedBy="cmsPages")
     * @ORM\JoinTable(name="cms_categories")
     */
    private $cmsCategories;
    
    /**
     * @ORM\ManyToOne(targetEntity="Admin\Entity\Settings", inversedBy="homeCmsPages")
     * @ORM\JoinColumns(
     *     @ORM\JoinColumn(name="setting_id", referencedColumnName="id")
     * )
     */
    private $settingHome;
    
    public function __construct()
    {
        if (method_exists($this, '_init')) {
            $this->_init();
        }
        
       $this->cmsCategories = new ArrayCollection();
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

    public function getCmsCategories(): Collection
    {
        return $this->cmsCategories;
    }

    public function setCmsCategories(?array $cmsCat)
    {
        // This is the owning side, we have to call remove and add to have change in the category side too.
       $this->cmsCategories->clear();
       $this->cmsCategories = new ArrayCollection($cmsCat);
        
       return $this;
    }

    public function addCmsCategory(CmsCategory $category)
    {
        if ($this->cmsCategories->contains($category)) {
            return;
        }
        
        $this->cmsCategories->add($category);
        $category->addCmsPage($this);
    }

    public function removeCmsCategory(CmsCategory $category)
    {
        if (!$this->cmsCategories->contains($category)) {
            return;
        }
        
        $this->cmsCategories->removeElement($category);
        $category->addCmsPage($this);
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

    public function getSettingHome(): ?Settings
    {
        return $this->settingHome;
    }

    public function setSettingHome(?Settings $settingHome): self
    {
        $this->settingHome = $settingHome;

        return $this;
    }
}