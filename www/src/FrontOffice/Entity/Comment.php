<?php

namespace FrontOffice\Entity;

use Core\Entity\IdTrait;
use Doctrine\ORM\Mapping as ORM;
use Admin\Entity\Product;
use Core\Entity\User;

/**
 * Comment
 *
 * @ORM\Table(name="Comment", indexes={@ORM\Index(name="Comment_user", columns={"user_id"}), @ORM\Index(name="Comment_product", columns={"product_id"})})
 * @ORM\Entity
 */
class Comment
{
    use IdTrait;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text", length=65535, nullable=false)
     */
    private $comment;

    /**
     * @var Product
     *
     * @ORM\ManyToOne(targetEntity="Admin\Entity\Product")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     * })
     */
    private $product;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="Core\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }


}
