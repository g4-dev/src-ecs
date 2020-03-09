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
            $category->setDescription($this->getRandomBody());

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
            $category->setDescription($this->getRandomBody());
        
            $this->addReference('cms-subcategory-'.$i, $category);
            $manager->persist($category);
        }
    
        $manager->flush();
    }

    private function getRandomBody()
    {
        $phrases = array(
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'Pellentesque vitae velit ex.',
            'Mauris dapibus, risus quis suscipit vulputate, eros diam egestas libero, eu vulputate eros eros eu risus.',
            'In hac habitasse platea dictumst.',
            'Morbi tempus commodo mattis.',
            'Donec vel elit dui.',
            'Ut suscipit posuere justo at vulputate.',
            'Phasellus id porta orci.',
            'Ut eleifend mauris et risus ultrices egestas.',
            'Aliquam sodales, odio id eleifend tristique, urna nisl sollicitudin urna, id varius orci quam id turpis.',
            'Nulla porta lobortis ligula vel egestas.',
            'Curabitur aliquam euismod dolor non ornare.',
            'Nunc et feugiat lectus.',
            'Nam porta porta augue.',
            'Sed varius a risus eget aliquam.',
            'Nunc viverra elit ac laoreet suscipit.',
            'Pellentesque et sapien pulvinar, consectetur eros ac, vehicula odio.',
        );

        $numPhrases = rand(5, 10);
        shuffle($phrases);

        return implode(' ', array_slice($phrases, 0, $numPhrases - 1));
    }
}
