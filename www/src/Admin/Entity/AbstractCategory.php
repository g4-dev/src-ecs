<?php
namespace Admin\Entity;

use Core\Entity\Model\Sluggable;
use Core\Entity\Traits\Id;
use Core\Entity\Traits\Name;
use Core\Entity\Traits\Slug;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class AbstractCategory.
 *
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({
 *     "cms_category" = "CmsCategory",
 *      "product_category" = "ProductCategory"
 * })
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="Admin\Repository\CategoryRepository")
 * @ORM\Table(indexes={@ORM\Index(name="search_idx",
 *     columns={"name"},
 *     options={"where": "(((id IS NOT NULL)"})
 * })
 */
abstract class AbstractCategory implements Sluggable {
    use Id;
    use Name;
    use Slug;

    /**
     * The description of the product.
     *
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;


    /**
     * Set the description of the product.
     *
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * The the full description of the product.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }


    public function __toString()
    {
        return (string) $this->getName();
    }
}