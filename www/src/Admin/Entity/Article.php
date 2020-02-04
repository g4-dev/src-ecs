<?php


namespace Admin\Entity;

use Core\Entity;
use Doctrine\ORM\Mapping as ORM;


/**
 * Article
 *
 * @ORM\Table(name="article", indexes={@ORM\Index(name="article_article_id", columns={"id"})})
 * @ORM\Entity
 */
class Article extends Entity\AbstractFile implements Entity\FileInterface
{
    use Entity\Traits\Id;
    
    /**
     * @ORM\Column(type="string")
     */
    private $title;
    
    /**
     * @ORM\Column(type="text")
     */
    private $body;
    
    /**
     * @var Entity\Admin
     *
     * @ORM\ManyToOne(targetEntity="Core\Entity\Admin")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="admin_id", referencedColumnName="id")
     * })
     */
    private $author;
    
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
    
    public function getAuthor(): ?Entity\Admin
    {
        return $this->author;
    }
    
    public function setAuthor(?Entity\Admin $author): self
    {
        $this->author = $author;
        
        return $this;
    }
    
    use Entity\Traits\CreatedAt;
}