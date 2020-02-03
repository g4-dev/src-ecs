<?php


namespace Admin\Entity;

use Core\Entity as CoreEn;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


/**
 * Article
 *
 * @ORM\Table(name="article", indexes={@ORM\Index(name="article_article_id", columns={"id"})})
 * @ORM\Entity
 */
class Article
{
    use CoreEn\Traits\Id;
    
    /**
     * @ORM\Column(type="string")
     */
    private $title;
    
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
     * @ORM\Column(type="string", length=255)
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
    
    public function getTitle(): ?string
    {
        return $this->title;
    }
    
    public function setTitle(string $title): self
    {
        $this->title = $title;
        
        return $this;
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
    
    use CoreEn\Traits\CreatedAt;
}