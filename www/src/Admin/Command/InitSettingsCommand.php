<?php


namespace Admin\Command;


use Admin\Entity\CmsPage;
use Admin\Entity\Diy;
use Admin\Entity\Settings;
use Admin\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class InitSettingsCommand extends Command
{
    const UNIQUE_ROW_ID  = 1;
    const DB_INIT = 'db_rebuild';
    
    private $em;
    
    private $makePath;
    
    public function __construct(Registry $em, string $makePath)
    {
        $this->em = $em;
        $this->makePath = $makePath;
        
        parent::__construct();
    }
    
    protected static $defaultName = 'ecs:init-app';
    
    protected function configure()
    {
        $this->setDescription('init all app requirements');
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $entityManager = $this->em->getManager();
        $actualSettings = $this->em->getRepository(Settings::class)
           ->find(self::UNIQUE_ROW_ID);
        
        if($actualSettings){
            $this->makefileInits();
            return 0;
        }
    
        $settings = (new Settings())
           ->setHomeProducts($this->getLastItems(Product::class, 4))
           ->setHomeDiys($this->getLastItems(Diy::class, 4))
           ->setHeadlineCmsPages($this->getLastItems(CmsPage::class,2))
           ->setFooterCmsPages($this->getLastItems(CmsPage::class,2))
           ->setId();
    
        $entityManager->persist($settings);
        $entityManager->flush();
        
        return 0;
    }
    
    private function getLastItems($entity, $qty){
        return $this->em->getRepository($entity)->findBy(
           [],
           ['createdAt' => 'ASC'],
           $qty,
           0
        );
    }
    
    private function makefileInits()
    {
        $process = new Process(['make','-C', $this->makePath, self::DB_INIT]);
        $process->run(null, [
           'db_rebuild' => self::DB_INIT,
           'make_path' => $this->makePath
        ]);
        
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
    
        echo "Successful created project";
    }
}