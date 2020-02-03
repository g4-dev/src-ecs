<?php


namespace Admin\Entity;

use Core\Entity\CreatedAtTrait;
use Core\Entity\IdTrait;
use Doctrine\ORM\Mapping as ORM;


/**
 * Article
 *
 * @ORM\Table(name="article", indexes={@ORM\Index(name="article_article_id", columns={"id"})})
 * @ORM\Entity
 */
class Article
{
    use IdTrait;
    use CreatedAtTrait;
    
    /**
     * @ORM\Column(type="string")
     */
    private string $title;
    
    /**
     * @ORM\Column(type="text")
     */
    private string $body;
    
    /**
     * @ORM\Column(type="string")
     */
    private string $image;
    
    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }
    
    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }
    
    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }
    
    /**
     * @param  string $body
     */
    public function setBody(string $body): void
    {
        $this->body = $body;
    }
    
    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }
    
    /**
     * @param mixed $image
     */
    public function setImage($image): void
    {
        $this->image = $image;
    }

}