<?php declare(strict_types = 1);

namespace VstupniTest\App\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\DescriptorHelper;
use Symfony\Component\Console\Question\Question;
use VstupniTest\Data\DataProvider\ContainerParametersProvider;

class LoadPidCommand extends Command
{
    protected $entityManager;

    protected $containerParametersProvider;

    public function __construct(
        \VstupniTest\Data\DataProvider\ContainerParametersProvider $containerParametersProvider,
        \VstupniTest\Factory\DoctrineFactory $doctrineFactory,
        string $name = null
    )
    {
        parent::__construct($name);
        $this->containerParametersProvider = $containerParametersProvider;
        $this->entityManager = $doctrineFactory->createEntityManagerBySettings();
    }

    public function configure(): void
    {
        $this->setName('load:pid')
            ->setDescription('load pids from json file');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln("<info>load point of sale started</info>");
        $filePath ='/var/www/vstupni_test/www/pointsOfSale.json';
        $fileContent = file_get_contents($filePath);
        $decodedJson = \json_decode($fileContent,true);
        foreach ($decodedJson as $row) {
            $pointOfSale = new \PointsOfSale();
            $pointOfSale->setPointOfSaleId($row['id']);
            $pointOfSale->setType($row['type']);
            $pointOfSale->setName($row['name']);
            $pointOfSale->setAddress($row['address']);
            $pointOfSale->setLat($row['lat']);
            $pointOfSale->setLon($row['lon']);
            $pointOfSale->setServices($row['services']);
            $pointOfSale->setPayMethods($row['payMethods']);
            $this->entityManager->persist($pointOfSale);
        }
        $this->entityManager->flush();


        return 0;
    }
}
