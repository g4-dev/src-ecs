<?php
namespace Admin\Entity;

use Core\Entity\Image;
use Core\Entity\Traits\DatesAt;
use Core\Entity\Traits\ImageGetters;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Class AbstractCategory.
 *
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({
 *     "cms_category" = "CmsCategory",
 *     "product_category" = "ProductCategory"
 * })
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="Admin\Repository\CategoryRepository")
 */
abstract class AbstractCategory extends AbstractSluggable {
    
    /**
     * It only stores the name of the image associated with the product.
     *
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $image;
    
    /**
     * This unmapped property stores the binary contents of the image file
     * associated with the product.
     *
     * @Vich\UploadableField(mapping="default_images", fileNameProperty="image")
     *
     * @var File
     */
    private $imageFile;
    
    use ImageGetters;
    
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
}