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
    
    public function __construct(Registry $doctrine, string $makePath)
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
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $actualSettings = $this->doctrine->getRepository(Settings::class)
           ->find(self::UNIQUE_ROW_ID);
        
        if($actualSettings){
            echo "Settings already here - [SKIPPING] \n";
            return 0;
        }
        
        $this->createSiteSettings($input->getOption('fillSettings'));
        echo "Settings created \n";
        return 0;
    }
    
    public function createSiteSettings(bool $fillSettings = true)
    {
        $entityManager = $this->doctrine->getManager();
        
        $settings = (new Settings())
           //->setHomeProducts($fillSettings ? $this->getLastItems(Product::class, 4) : null)
           ->setHomeDiys($fillSettings ? $this->getLastItems(Diy::class, 4) : null)
           ->setHeadlineCmsPages($fillSettings ? $this->getLastItems(CmsPage::class,2) : null)
           ->setFooterCmsPages($fillSettings ?  $this->getLastItems(CmsPage::class,2) : null)
           ->setId();
    
        $entityManager->persist($settings);
        $entityManager->flush();
    }
    
    protected function getLastItems($entity, $qty){
        return $this->doctrine->getRepository($entity)->findBy(
           [],
           ['createdAt' => 'ASC'],
           $qty,
           0
        );
    }
}