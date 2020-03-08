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
        $actualSettings = $this->doctrine->getRepository(Settings::class)
           ->find(self::UNIQUE_ROW_ID);
        
        if($actualSettings){
            echo "Settings already here - [SKIPPING] \n";
            return 0;
        }
        
        $this->createSiteSettings();
        echo "Settings created \n";
        return 0;
    }
    
    public function createSiteSettings()
    {
        $entityManager = $this->doctrine->getManager();
        $diy = $this->getLastItems(Diy::class, 1);
        $page = $this->getLastItems(CmsPage::class,1);
        $product = $this->getLastItems(Product::class,1);
        
        $settings = new Settings();
        $diy ? $settings->addHomeDiy($diy[0]) : null;
        $page ? $settings->addHomeCmsPage($page[0]) : null;
        $product ? $settings->addHomeProduct($product[0]): null;
    
        $entityManager->persist($settings);
        $entityManager->flush();
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