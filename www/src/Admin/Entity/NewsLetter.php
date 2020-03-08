<?php

namespace Admin\Entity;

use Core\Entity\Admin;
use Core\Entity\Traits\Id;
use Core\Entity\Traits\Name;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Admin\Repository\NewsLetterRepository")
 */
class NewsLetter
{
    use Id;
    use Name;

    /**
     * @ORM\ManyToOne(targetEntity="Core\Entity\Admin", inversedBy="newsLetters")
     * @ORM\JoinColumn(nullable=false)
     */
    private $admin;

    /**
     * @ORM\Column(type="text")
     */
    private $body;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdmin(): ?Admin
    {
        return $this->admin;
    }

    public function setAdmin(?Admin $admin): self
    {
        $this->admin = $admin;

        return $this;
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
}
