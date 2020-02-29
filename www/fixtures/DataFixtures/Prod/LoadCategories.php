<?php

namespace Fixtures\DataFixtures\Prod;

use Admin\Entity\CmsCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Admin\Entity\ProductCategory;

class LoadCategories extends Fixture implements OrderedFixtureInterface
{
    public function getOrder()
    {
        return 20;
    }

    public function load(ObjectManager $manager)
    {
        foreach (range(0, 9) as $i) {
            $category = new ProductCategory();
            $category->setName('ProductCategory #'.$i);

            $this->addReference('product-category-'.$i, $category);
            $manager->persist($category);
        }

        $manager->flush();

        foreach (range(0, 99) as $i) {
            $category = new ProductCategory();
            $category->setName('ProductSubcategory #'.$i);
            $category->setParent($this->getReference('product-category-'.($i % 10)));

            $this->addReference('product-subcategory-'.$i, $category);
            $manager->persist($category);
        }

        $manager->flush();
    
        // Cms categories creation
        foreach (range(0, 9) as $i) {
            $category = new CmsCategory();
            $category->setName('CmsCategory #'.$i);
        
            $this->addReference('cms-category-'.$i, $category);
            $manager->persist($category);
        }
    
        $manager->flush();
    
        foreach (range(0, 99) as $i) {
            $category = new CmsCategory();
            $category->setName('CmsSubcategory #'.$i);
            $category->setParent($this->getReference('cms-category-'.($i % 10)));
        
            $this->addReference('cms-subcategory-'.$i, $category);
            $manager->persist($category);
        }
    
        $manager->flush();
    }
}
