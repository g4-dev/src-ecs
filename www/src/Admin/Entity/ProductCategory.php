<?php

namespace Admin\Entity;

use Core\Entity\Image;
use Core\Entity\Model\Sluggable;
use Core\Entity\Traits\DatesAt;
use Core\Entity\Traits\Id;
use Core\Generics\Collection\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Class Category.
 *
 * @ORM\MappedSuperclass
 * @ORM\Table(name="product_category")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="Admin\Repository\ProductCategoryRepository")
 * @Vich\Uploadable
 */
class ProductCategory extends AbstractSluggable
{
    use Id;
    use DatesAt;
    use TraitCategory;
    
    /**
     * Product in the category.
     *
     * @var                                    Product[]
     * @ORM\ManyToMany(targetEntity="Product", mappedBy="category")
     **/
    protected $items;

    /**
     * The category parent.
     *
     * @var                                           ProductCategory
     * @ORM\ManyToOne(targetEntity="ProductCategory")
     * @ORM\JoinColumn(name="parent_id",              referencedColumnName="id", nullable=true)
     **/
    protected $parent;
}
