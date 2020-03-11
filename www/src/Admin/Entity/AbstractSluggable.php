<?php


namespace Admin\Entity;


use Core\Entity\Model\Sluggable;
use Core\Entity\Traits\Id;
use Core\Entity\Traits\Name;
use Core\Entity\Traits\Slug;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({
 *     "abstract_category" = "AbstractCategory",
 *     "category_cms" = "CmsCategory",
 *     "product_category" = "ProductCategory",
 *     "product" = "Product",
 *     "cms_page" = "CmsPage",
 *     "diy" = "Diy"
 * })
 * @ORM\Entity(repositoryClass="Admin\Repository\SlugRepository")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(indexes={@ORM\Index(name="search_idx",
 *     columns={"name"},
 *     options={"where": "(((id IS NOT NULL)"})
 * })
 */
abstract class AbstractSluggable implements Sluggable
{
    use Id;
    use Name;
    use Slug;
    
    public function __toString()
    {
        return $this->getSlug();
    }
}