<?php

namespace Admin\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class CmsCategory.
 *
 * @ORM\Table(name="cms_category")
 * @ORM\Entity(repositoryClass="Admin\Repository\CategoryRepository")
 * @ORM\MappedSuperclass
 */
class CmsCategory extends AbstractCategory
{
    /**
     * Product in the category.
     *
     * @var CmsPage[]
     * @ORM\ManyToMany(targetEntity="CmsPage", mappedBy="cmsCategories")
     **/
    protected $cmsPages;

    /**
     * The category parent.
     *
     * @var CmsCategory
     * @ORM\ManyToOne(targetEntity="CmsCategory")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", nullable=true)
     **/
    protected $parent;

    public function __construct()
    {
        $this->cmsPages = new ArrayCollection();
    }

    /**
     * Set the parent category.
     *
     * @param CmsCategory $parent
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    /**
     * Get the parent category.
     *
     * @return CmsCategory
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Return all pages associated to the category.
     *
     * @return CmsPage[]
     */
    public function getCmsPages()
    {
        return $this->cmsPages;
    }

    /**
     * Set all pages in the category.
     *
     * @param CmsPage[] $products
     */
    public function setCmsPages($cmsPages)
    {
        $this->cmsPages->clear();
        $this->cmsPages = new ArrayCollection($cmsPages);
    }

    /**
     * Add a product in the category.
     *
     * @param $product Product The product to associate
     */
    public function addCmsPage(CmsPage $cmspage)
    {
        if ($this->cmsPages->contains($cmspage)) {
            return;
        }

        $this->cmsPages->add($cmspage);
        $cmspage->addCmsCategory($this);
    }

    /**
     * @param Product $product
     */
    public function removeCmsPage(CmsPage $cmsPage)
    {
        if (!$this->cmsPages->contains($cmsPage)) {
            return;
        }

        $this->cmsPages->removeElement($cmsPage);
        $cmsPage->removeCmsCategory($this);
    }
}
