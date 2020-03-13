<?php

namespace Fixtures\DataFixtures\Prod;

use Admin\Entity\CmsCategory;
use Admin\Entity\Nav;
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

        //textile
            $category = new ProductCategory();
            $category->setName('Textile');
            $category->setDescription('4 millions de tonnes de textiles sont jetés chaque années en Europe.');
            $this->addReference('textile', $category);
            $manager->persist($category);
            $manager->flush();

            //cuisine
        $category = new ProductCategory();
        $category->setName('Cuisine');
        $category->setDescription('Tous nos ustensiles sont prêts à l\'emploi et de qualité professionnelle');
        $this->addReference('cuisine', $category);
        $manager->persist($category);
        $manager->flush();

        //jardin
        $category = new ProductCategory();
        $category->setName('Jardin');
        $category->setDescription('C\'est votre petit jardin secret...');
        $this->addReference('jardin', $category);
        $manager->persist($category);
        $manager->flush();

        //electro
        $category = new ProductCategory();
        $category->setName('Electroménager');
        $category->setDescription('Garantie 2 ans à compter de la date d\'achat. Tous les appareils sont reconditionnés.');
        $this->addReference('electro', $category);
        $manager->persist($category);
        $manager->flush();

        //maison
        $category = new ProductCategory();
        $category->setName('Maison');
        $category->setDescription('Bureau, tables, tout pour meubler votre maison à moindres frais !');
        $this->addReference('maison', $category);
        $manager->persist($category);
        $manager->flush();

//        foreach (range(0, 31) as $i) {
            $category = new ProductCategory();
            $category->setName('ProductSubcategory #');
//            $category->setParent($this->getReference('product-category-'.($i % 10)));
        $category->setParent($this->getReference('textile'));
            $category->setDescription($this->getRandomBody());

//            $this->addReference('product-subcategory-'.$i, $category);
        $this->addReference('product-subcategory-', $category);
            $manager->persist($category);
//        }

        $manager->flush();
    
        // Cms categories creation
        foreach (range(0, 6) as $i) {
            $category = new CmsCategory();
            $category->setName('CmsCategory #'.$i);
            $category->setDescription($this->getRandomBody());
            
            $this->addReference('cms-category-'.$i, $category);
            $manager->persist($category);
        }
    

        $manager->flush();

        foreach (range(0, 4) as $i) {
            $category = new CmsCategory();
            $category->setName('CmsSubcategory #'.$i);
            $category->setParent($this->getReference('cms-category-'.($i % 10)));
            $category->setDescription($this->getRandomBody());

            $this->addReference('cms-subcategory-'.$i, $category);
            $manager->persist($category);
        }

        $manager->flush();

        /*foreach (range(27,31) as $i) {
            $nav = new Nav();
            $nav->setName('category-'.$i);
            $nav->setPosition($i);
            $nav->setPage($this->getReference('product-category-'.$i));
            $manager->persist($nav);
        }*/
        //Le nav
        //Textile
        $nav = new Nav();
        $nav->setName('Textile');
        $nav->setPosition(1);
//        $nav->setPage($this->getReference('product-category-'.$i));
        $nav->setPage($this->getReference('textile'));
        $manager->persist($nav);
        $manager->flush();

        //Cuisine
        $nav = new Nav();
        $nav->setName('Cuisine');
        $nav->setPosition(2);
        $nav->setPage($this->getReference('cuisine'));
        $manager->persist($nav);
        $manager->flush();

        //jardinage
        $nav = new Nav();
        $nav->setName('Jardin');
        $nav->setPosition(3);
        $nav->setPage($this->getReference('jardin'));
        $manager->persist($nav);
        $manager->flush();

        //electromenager
        $nav = new Nav();
        $nav->setName('Electroménager');
        $nav->setPosition(4);
        $nav->setPage($this->getReference('electro'));
        $manager->persist($nav);
        $manager->flush();

        //maison
        $nav = new Nav();
        $nav->setName('Maison');
        $nav->setPosition(5);
        $nav->setPage($this->getReference('maison'));
        $manager->persist($nav);
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
