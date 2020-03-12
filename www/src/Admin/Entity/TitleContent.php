<?php

namespace Admin\Entity;

use Core\Entity\Admin;
use Core\Entity\Traits\Id;
use Core\Entity\Traits\IsActive;
use Core\Entity\Traits\Name;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class TitleContent
{
    use Id;
    use Name;

    /**
     * @ORM\Column(type="text")
     */
    private $body;

    /**
     * @ORM\ManyToOne(targetEntity="CmsPage", inversedBy="titleContents")
     * @ORM\JoinColumn(nullable=true)
     */
    private $cmsPage;

    public function __construct()
    {
        $this->admin = new ArrayCollection();
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

    public function getCmsPage(): ?CmsPage
    {
        return $this->cmsPage;
    }

    public function setCmsPage(?CmsPage $cmsPage): self
    {
        $this->cmsPage = $cmsPage;

        return $this;
    }
}
