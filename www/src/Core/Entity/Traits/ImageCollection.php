<?php


namespace Core\Entity\Traits;


use Core\Entity\Image;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

trait ImageCollection
{
    /**
     * @var Image[]|ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Core\Entity\Image", cascade={"persist"})
     * @ORM\JoinTable(name="product_images",
     *      joinColumns={@ORM\JoinColumn(name="item_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="image_id", referencedColumnName="id", unique=true)}
     * )
     */
    private $images;
    
    public function _initImages()
    {
        $this->images = new ArrayCollection();
    }
    
    /**
     * @return Image[]|null
     */
    public function getImages(): ?Collection
    {
        return $this->images;
    }
    
    public function setImages(array $images): self
    {
        $this->images->clear();
        $this->images = new ArrayCollection($images);
        
        return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return (string) $this->getName();
    }
}