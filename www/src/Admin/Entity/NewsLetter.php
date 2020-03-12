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
 * @ORM\Entity(repositoryClass="Admin\Repository\NewsLetterRepository")
 */
class NewsLetter
{
    use Id;
    use Name;

    /**
     * @ORM\Column(type="text")
     */
    private $body;

    /**
     * @ORM\ManyToOne(targetEntity="Core\Entity\Admin", inversedBy="newsLetters")
     * @ORM\JoinColumn(nullable=true)
     */
    private $admin;

    public function __construct()
    {
        $this->admin = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection|Admin[]
     */
    public function getAdmin(): Collection
    {
        return $this->admin;
    }

    public function addAdmin(Admin $admin): self
    {
        if (!$this->admin->contains($admin)) {
            $this->admin[] = $admin;
        }

        return $this;
    }

    public function removeAdmin(Admin $admin): self
    {
        if ($this->admin->contains($admin)) {
            $this->admin->removeElement($admin);
        }

        return $this;
    }

    public function setAdmin(?Admin $admin): self
    {
        $this->admin = $admin;

        return $this;
    }
}
