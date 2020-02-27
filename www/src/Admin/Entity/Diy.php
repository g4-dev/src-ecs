<?php


namespace Admin\Entity;

use Core\Entity as CoreEn;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Article
 *
 * @ORM\Table(name="cms_diy", indexes={@ORM\Index(name="index_cms_page_id", columns={"id","name"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @Vich\Uploadable
 *
 */
class Diy implements \Core\Entity\Model\Sluggable
{
    // Name == title
    use CoreEn\Traits\Name;
    use CoreEn\Traits\Id;
    use CoreEn\Traits\DatesAt;
    use CoreEn\Traits\Slug;
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
     * List of tags associated to the product.
     *
     * @var string[]
     * @ORM\Column(type="simple_array")
     */
    private $tags = array();
    
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
     * @ORM\ManyToOne(targetEntity="Admin\Entity\Settings", inversedBy="homeDiys")
     * @ORM\JoinColumn(nullable=true)
     */
    private $settingsHome;
    
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
     * Set the list of the tags.
     *
     * @param \string[] $tags
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
    }
    
    /**
     * Get the list of tags associated to the product.
     *
     * @return \string[]
     */
    public function getTags()
    {
        return $this->tags;
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

    public function getSettingsHome(): ?Settings
    {
        return $this->settingsHome;
    }

    public function setSettingsHome(?Settings $settingsHome): self
    {
        $this->settingsHome = $settingsHome;

        return $this;
    }
}