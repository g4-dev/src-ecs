<?php

namespace Admin\Entity;

use Core\Entity\Admin;
use Core\Entity\Traits\DatesAt;
use Core\Entity\Traits\Id;
use Core\Entity\Traits\IsActive;
use Core\Entity\Traits\Name;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Admin\Repository\NewsLetterRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Letter
{
    use Id;
    use Name;
    use DatesAt;

    /**
     * @ORM\Column(type="text")
     */
    private $body;

    /**
     * @ORM\ManyToOne(targetEntity="Core\Entity\Admin", inversedBy="letters")
     * @ORM\JoinColumn(nullable=true)
     */
    private $admin;

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

    public function getAdmin()
    {
        return $this->admin;
    }

    public function setAdmin(?Admin $admin): self
    {
        $this->admin = $admin;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
