<?php


namespace Core\Entity\Traits;


use Admin\Entity\TitleContent;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

trait TitleContents
{
    /**
     * @ORM\ManyToMany(targetEntity="Admin\Entity\TitleContent", cascade={"persist"})
     * @ORM\JoinTable()
     */
    private $titleContents;
    
    public function _initTitleContents()
    {
        $this->titleContents = new ArrayCollection();
    }
    
    /**
     * @return Collection|TitleContent[]
     */
    public function getTitleContents(): Collection
    {
        return $this->titleContents;
    }
    
    public function setTitleContents(array $titleContents): self
    {
        $this->titleContents->clear();
        $this->titleContents = new ArrayCollection($titleContents);
        
        return $this;
    }
}