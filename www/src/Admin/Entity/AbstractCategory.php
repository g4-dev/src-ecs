<?php
namespace Admin\Entity;

use Core\Entity\Traits\Id;
use Core\Entity\Traits\Name;
use Core\Entity\Traits\Slug;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class AbstractCategory.
 *
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"cms_category" = "CmsCategory", "product_category" = "ProductCategory"})
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity
 */
abstract class AbstractCategory{
    use Id;
    use Name;
    use Slug;
    
    public function __toString()
    {
        return (string) $this->getName();
    }
}