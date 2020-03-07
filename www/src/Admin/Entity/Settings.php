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
     * @ORM\Column(type="smallint", length=1)
     */
    private $id;
    
    /**
     * @ORM\OneToMany(targetEntity="Admin\Entity\Diy", mappedBy="settingsHome", cascade={"persist"})
     * @Assert\Unique(message="validator.generics.in_collection_exist")
     */
    private $homeDiys;
    
    /**
     * @ORM\OneToMany(targetEntity="Admin\Entity\CmsPage", orphanRemoval=true, mappedBy="settingsHeadline")
     * @ORM\JoinColumns({
     *      @ORM\JoinColumn(name="headline_cms_page_id", referencedColumnName="id")
     * })
     * @Assert\Unique(message="validator.generics.in_collection_exist")
     */
    private $headlineCmsPages;
    
    /**
     * @ORM\OneToMany(targetEntity="Admin\Entity\CmsPage", orphanRemoval=true, mappedBy="settingsFooter")
     * @ORM\JoinColumns({
     *      @ORM\JoinColumn(name="footer_cms_page_id", referencedColumnName="id")
     * })
     * @Assert\Unique(message="validator.generics.in_collection_exist")
     */
    private $footerCmsPages;
    
    public function __construct()
    {
        $this->homeDiys = new ArrayCollection();
        $this->headlineCmsPages = new ArrayCollection();
        $this->footerCmsPages = new ArrayCollection();
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function setId(): Settings
    {
        if ($this->id === 1) {
            return $this;
        }
        
        $this->id = 1;
        
        return $this;
    }
    
    public function getHomeDiys(): Collection
    {
        return $this->homeDiys;
    }
    
    public function setHomeDiys(?array $homeDiys = []): self
    {
        foreach ($homeDiys as $diy) {
            $this->addHomeDiy($diy);
        }
        
        return $this;
    }
    
    public function addHomeDiy(Diy $homeDiy): self
    {
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
    
    public function getHeadlineCmsPages(): Collection
    {
        return $this->headlineCmsPages;
    }

    public function setHeadlineCmsPages(?array $headlineCmsPages = []): self
    {
        foreach ($headlineCmsPages as $page) {
            $this->addHeadlineCmsPage($page);
        }
        
        return $this;
    }
    
    public function addHeadlineCmsPage(CmsPage $headlineCmsPage)
    {
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

    public function getFooterCmsPages(): Collection
    {
        return $this->footerCmsPages;
    }

    public function setFooterCmsPages(?array $footerCmsPages): self
    {
        foreach ($footerCmsPages as $page) {
            $this->addFooterCmsPage($page);
        }
        
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
        dump("Gros persist qui fait bien mal");
    }
}

