<?php

namespace Admin\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Core\Entity\Model\Sluggable;

/**
 * @ORM\Entity(repositoryClass="Admin\Repository\SettingsRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Settings

{
    /**
     * @ORM\Id
     * @ORM\Column(type="smallint", length=1, options={"default" : 0})
     */
    private $id = 0;
    
    /**
     * @ORM\OneToMany(targetEntity="Core\Entity\Model\Sluggable", mappedBy="settingsHome", cascade={"persist"})
     * @Assert\Unique(message="validator.generics.in_collection_exist")
     */
    private $homeDiys;
    
    /**
     * @ORM\OneToMany(targetEntity="Core\Entity\Model\Sluggable", orphanRemoval=true, mappedBy="settingsHeadline")
     * @Assert\Unique(message="validator.generics.in_collection_exist")
     */
    private $headlineCmsPages;
    
    /**
     * @ORM\OneToMany(targetEntity="Core\Entity\Model\Sluggable", orphanRemoval=true, mappedBy="settingsFooter")
     * @Assert\Unique(message="validator.generics.in_collection_exist")
     */
    private $footerCmsPages;
    
    public function __construct()
    {
        $this->homeDiys = new ArrayCollection();
        $this->headlineCmsPages = new ArrayCollection();
        $this->footerCmsPages = new ArrayCollection();
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
    
    public function addHomeDiy(Diy $homeDiy): self
    {
        if(count($this->homeDiys) >= 4) {
            return new \Exception("maximum.error");
        }
        
        if (!$this->homeDiys->contains($homeDiy)) {
            $this->homeDiys[] = $homeDiy;
            $homeDiy->setSettingsHome($this);
        }
        
        return $this;
    }
    
    public function removeHomeDiy(Diy $homeDiy): self
    {
        if ($this->homeDiys->contains($homeDiy)) {
            $this->homeDiys->removeElement($homeDiy);
            // set the owning side to null (unless already changed)
            if ($homeDiy->getSettingsHome() === $this) {
                $homeDiy->setSettingsHome(null);
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
            $headlineCmsPage->setSettingsHeadline($this);
        }
        
        return $this;
    }
    
    public function removeHeadlineCmsPage(CmsPage $headlineCmsPage): self
    {
        if ($this->headlineCmsPages->contains($headlineCmsPage)) {
            $this->headlineCmsPages->removeElement($headlineCmsPage);
            // set the owning side to null (unless already changed)
            if ($headlineCmsPage->getSettingsHeadline() === $this) {
                $headlineCmsPage->setSettingsHeadline(null);
            }
        }
        
        return $this;
    }

    /**
     * @return Collection|CmsPage[]
     */
    public function getFooterCmsPages(): Collection
    {
        return $this->footerCmsPages;
    }
    
    /**
     * @param object $footerCmsPages
     * @return Settings
     */
    public function setFooterCmsPages($footerCmsPages)
    {
        $this->footerCmsPages = $footerCmsPages;
        
        return $this;
    }

    public function addFooterCmsPage(CmsPage $footerPages): self
    {
        if (!$this->footerCmsPages->contains($footerPages)) {
            $this->footerCmsPages[] = $footerPages;
            $footerPages->setSettingsHeadline($this);
        }

        return $this;
    }

    public function removeFooterCmsPage(CmsPage $footerPages): self
    {
        if ($this->footerCmsPages->contains($footerPages)) {
            $this->footerCmsPages->removeElement($footerPages);
            // set the owning side to null (unless already changed)
            if ($footerPages->getSettingsHeadline() === $this) {
                $footerPages->setSettingsHeadline(null);
            }
        }

        return $this;
    }
    
    /**
     * @ORM\PrePersist()
     */
    public function onPrePersitFooterCmsPageAdd(){
        dump("zigwiwiwwiw");
    }
}

