<?php

namespace Admin\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Admin\Repository\SettingsRepository")
 */
class Settings

{
    /**
     * @ORM\Id
     * @ORM\Column(type="smallint", length=1, options={"default" : 0})
     */
    private $id = 0;
    
    /**
     * @ORM\OneToMany(targetEntity="Admin\Entity\Diy", mappedBy="settings")
     * @Assert\Unique(message="validator.generics.in_collection_exist")
     */
    private $homeDiys;
    
    /**
     * @ORM\OneToMany(targetEntity="Admin\Entity\Product", mappedBy="settings")
     * @Assert\Unique(message="validator.generics.in_collection_exist")
     */
    private $homeProducts;
    
    /**
     * @ORM\OneToMany(targetEntity="Admin\Entity\CmsPage", mappedBy="settings")
     * @Assert\Unique(message="validator.generics.in_collection_exist")
     */
    private $headlineCmsPages;
    
    /**
     * @ORM\OneToMany(targetEntity="Admin\Entity\CmsPage", mappedBy="settings")
     * @Assert\Unique(message="validator.generics.in_collection_exist")
     */
    private $footerPages;
    
    public function __construct()
    {
        $this->homeDiys = new ArrayCollection();
        $this->headlineCmsPages = new ArrayCollection();
        $this->homeProducts = new ArrayCollection();
        $this->footerPages = new ArrayCollection();
    }
    
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * @return Settings
     */
    public function setId(): Settings
    {
        if ($this->id === 1) {
            return $this;
        }
        
        $this->id = 1;
        
        return $this;
    }
    
    /**
     * @return Collection|Diy[]
     */
    public function getHomeDiys(): Collection
    {
        return $this->homeDiys;
    }
    
    /**
     * @return Collection|Product[]
     */
    public function getHomeProducts(): Collection
    {
        return $this->homeProducts;
    }
    
    public function addHomeDiy(Diy $homeDiy): self
    {
        if(count($this->homeDiys) >= 4) {
            return new \Exception("maximum.error");
        }
        
        if (!$this->homeDiys->contains($homeDiy)) {
            $this->homeDiys[] = $homeDiy;
            $homeDiy->setSettings($this);
        }
        
        return $this;
    }
    
    public function removeHomeDiy(Diy $homeDiy): self
    {
        if ($this->homeDiys->contains($homeDiy)) {
            $this->homeDiys->removeElement($homeDiy);
            // set the owning side to null (unless already changed)
            if ($homeDiy->getSettings() === $this) {
                $homeDiy->setSettings(null);
            }
        }
        
        return $this;
    }
    
    /**
     * @param mixed $homeDiys
     * @return Settings
     */
    public function setHomeDiys($homeDiys)
    {
        $this->homeDiys = $homeDiys;
        
        return $this;
    }
    
    /**
     * @param mixed $homeProducts
     * @return Settings
     */
    public function setHomeProducts($homeProducts)
    {
        $this->homeProducts = $homeProducts;
        
        return $this;
    }
    
    /**
     * @return Collection|Product[]|\Exception
     */
    public function addHomeProduct(Product $homeProduct): self
    {
        if(count($this->homeProducts) >= 4) {
            return new \Exception("maximum.error");
        }
        
        if (!$this->homeProducts->contains($homeProduct)) {
            $this->homeProducts[] = $homeProduct;
            $homeProduct->setSettings($this);
        }
        
        return $this;
    }
    
    public function removeHomeProduct(CmsPage $homeProduct): self
    {
        if ($this->homeProducts->contains($homeProduct)) {
            $this->homeProducts->removeElement($homeProduct);
            // set the owning side to null (unless already changed)
            if ($homeProduct->getSettings() === $this) {
                $homeProduct->setSettings(null);
            }
        }
        
        return $this;
    }
    
    /**
     * @return Collection|CmsPage[]
     */
    public function getHeadlineCmsPages(): Collection
    {
        return $this->headlineCmsPages;
    }
    
    /**
     * @param mixed $headlineCmsPages
     * @return Settings
     */
    public function setHeadlineCmsPages($headlineCmsPages)
    {
        $this->headlineCmsPages = $headlineCmsPages;
        
        return $this;
    }
    
    public function addHeadlineCmsPage(CmsPage $headlineCmsPage): self
    {
        if(count($this->headlineCmsPages) >= 2) {
            return new \Exception("maximum.error");
        }
        
        if (!$this->headlineCmsPages->contains($headlineCmsPage)) {
            $this->headlineCmsPages[] = $headlineCmsPage;
            $headlineCmsPage->setSettings($this);
        }
        
        return $this;
    }
    
    public function removeHeadlineCmsPage(CmsPage $headlineCmsPage): self
    {
        if ($this->headlineCmsPages->contains($headlineCmsPage)) {
            $this->headlineCmsPages->removeElement($headlineCmsPage);
            // set the owning side to null (unless already changed)
            if ($headlineCmsPage->getSettings() === $this) {
                $headlineCmsPage->setSettings(null);
            }
        }
        
        return $this;
    }

    /**
     * @return Collection|CmsPage[]
     */
    public function getFooterPages(): Collection
    {
        return $this->footerPages;
    }
    
    /**
     * @param Collection|CmsPage[] $footerPages
     * @return Settings
     */
    public function setFooterPages(Collection $footerPages)
    {
        $this->footerPages = $footerPages;
        
        return $this;
    }

    public function addFooterPagesList(CmsPage $footerPages): self
    {
        if (!$this->footerPages->contains($footerPages)) {
            $this->footerPages[] = $footerPages;
            $footerPages->setSettings($this);
        }

        return $this;
    }

    public function removeFooterPagesList(CmsPage $footerPages): self
    {
        if ($this->footerPages->contains($footerPages)) {
            $this->footerPages->removeElement($footerPages);
            // set the owning side to null (unless already changed)
            if ($footerPages->getSettings() === $this) {
                $footerPages->setSettings(null);
            }
        }

        return $this;
    }
}
