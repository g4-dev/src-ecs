<?php


namespace Admin\Entity;

use Core\Entity as CoreEn;
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
     * @ORM\ManyToOne(targetEntity="Settings", inversedBy="headlineCmsPages")
     * @ORM\JoinColumn(nullable=true)
     */
    private $settingsHeadline;
    
    /**
     * @ORM\ManyToOne(targetEntity="Settings", inversedBy="footerCmsPages")
     * @ORM\JoinColumn(nullable=true)
     */
    private $settingsFooter;
    
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
    
    /**
     * @return CmsCategory[]
     */
    public function getCmsCategories()
    {
        return $this->cmsCategories;
    }
    
    /**
     * Add a category in the page association.
     * (Owning side).
     *
     * @param $category CmsCategory the category to associate
     */
    public function addCmsCategory($category)
    {
        if ($this->cmsCategories->contains($category)) {
            return;
        }
        
        $this->cmsCategories->add($category);
        $category->addCmsPage($this);
    }
    
    /**
     * Remove a category in the product association.
     * (Owning side).
     *
     * @param $category CmsCategory the category to associate
     */
    public function removeCmsCategory($category)
    {
        if (!$this->cmsCategories->contains($category)) {
            return;
        }
        
        $this->cmsCategories->removeElement($category);
        $category->addCmsPage($this);
    }

    public function getSettingsHeadline(): ?Settings
    {
        return $this->settingsHeadline;
    }

    public function setSettingsHeadline(?Settings $settingsHeadline): self
    {
        $this->settingsHeadline = $settingsHeadline;

        return $this;
    }
    
    public function getSettingsFooter(): ?Settings
    {
        return $this->settingsFooter;
    }

    public function setSettingsFooter(?Settings $settingsFooter): self
    {
        $this->settingsFooter = $settingsFooter;

        return $this;
    }
}