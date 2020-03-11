<?php


namespace Admin\Command;


use Admin\Entity\CmsPage;
use Admin\Entity\Diy;
use Admin\Entity\Settings;
use Admin\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InitSettingsCommand extends Command
{
    const UNIQUE_ROW_ID  = 1;
    
    private $doctrine;
    
    private $makePath;
    
    public function __construct(Registry $doctrine, string $makePath = null)
    {
        $this->doctrine = $doctrine;
        $this->makePath = $makePath;
        
        parent::__construct();
    }
    
    protected static $defaultName = 'ecs:init-app';
    
    protected function configure()
    {
        $this->setDescription('init app settings');
        $this->addOption('fillSettings', 'f',InputOption::VALUE_OPTIONAL,'fill settings with last items.', false);
    }
    
    public function execute(?InputInterface $input, ?OutputInterface $output)
    {
        $entityManager = $this->doctrine->getManager();
        $products = $this->getLastItems(Product::class, 3);
        
        foreach ($products as $c) {
            $c->setOnhome(true);
            $entityManager->persist($c);
        }
    
        $diys = $this->getLastItems(Diy::class, 4);
        
        foreach ($diys as $d) {
            $d->setOnhome(true);
            $entityManager->persist($d);
        }
    
        $cmsPages = $this->getLastItems(Diy::class, 2);
        
        foreach ($cmsPages as $c) {
            $c->setOnhome(true);
            $entityManager->persist($c);
        }
        
        echo "Settings created \n";
        return 0;
    }

    protected function getLastItems($entity, $qty)
    {
        return $this->doctrine->getRepository($entity)->findBy(
           [],
           ['createdAt' => 'ASC'],
           $qty,
           0
        );
    }
}