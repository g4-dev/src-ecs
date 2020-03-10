<?php

namespace Admin\Entity;

use Core\Entity\Traits\Id;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Admin\Repository\SettingsRepository")
 * @ORM\ChangeTrackingPolicy("NOTIFY")
 */
class Settings
{
    use Id;

    /**
     * @ORM\OneToMany(targetEntity="Admin\Entity\Diy", mappedBy="settingHome")
     */
    private $homeDiys;

    /**
     * @ORM\OneToMany(targetEntity="Admin\Entity\CmsPage", mappedBy="settingHome")
     * @ORM\JoinColumns(
     *     @ORM\JoinColumn(name="setting_id", referencedColumnName="id")
     * )
     */
    private $homeCmsPages;

    /**
     * @ORM\OneToMany(targetEntity="Admin\Entity\Product",  mappedBy="settingHome")
     */
    private $homeProducts;

    public function __construct()
    {
        $this->id = 1;
        $this->homeDiys = new ArrayCollection();
        $this->homeCmsPages = new ArrayCollection();
        $this->homeProducts = new ArrayCollection();
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
        if (!$this->homeDiys->contains($homeDiy)) {
            $this->homeDiys[] = $homeDiy;
            $homeDiy->setSettingHome($this);
        }

        return $this;
    }

    public function removeHomeDiy(Diy $homeDiy): self
    {
        if ($this->homeDiys->contains($homeDiy)) {
            $this->homeDiys->removeElement($homeDiy);
            // set the owning side to null (unless already changed)
            if ($homeDiy->getSettingHome() === $this) {
                $homeDiy->setSettingHome(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CmsPage[]
     */
    public function getHomeCmsPages(): Collection
    {
        return $this->homeCmsPages;
    }

    public function addHomeCmsPage(CmsPage $homeCmsPage): self
    {
        if (!$this->homeCmsPages->contains($homeCmsPage)) {
            $this->homeCmsPages[] = $homeCmsPage;
            $homeCmsPage->setSettingHome($this);
        }

        return $this;
    }

    public function removeHomeCmsPage(CmsPage $homeCmsPage): self
    {
        if ($this->homeCmsPages->contains($homeCmsPage)) {
            $this->homeCmsPages->removeElement($homeCmsPage);
            // set the owning side to null (unless already changed)
            if ($homeCmsPage->getSettingHome() === $this) {
                $homeCmsPage->setSettingHome(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getHomeProducts(): Collection
    {
        return $this->homeProducts;
    }

    public function addHomeProduct(Product $homeProduct): self
    {
        if (!$this->homeProducts->contains($homeProduct)) {
            $this->homeProducts[] = $homeProduct;
            $homeProduct->setSettingHome($this);
        }

        return $this;
    }

    public function removeHomeProduct(Product $homeProduct): self
    {
        if ($this->homeProducts->contains($homeProduct)) {
            $this->homeProducts->removeElement($homeProduct);
            // set the owning side to null (unless already changed)
            if ($homeProduct->getSettingHome() === $this) {
                $homeProduct->setSettingHome(null);
            }
        }

        return $this;
    }
    
    public function __toString(): string
    {
        return (string) $this->getId();
    }
}
