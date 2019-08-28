<?php declare(strict_types=1);


namespace VstupniTest\App\Factory;


use VstupniTest\App\Entity\Collection\PointOfSaleCollection;

class PointOfSaleFactory
{
    /** @var \VstupniTest\Factory\IpGeoLocation  */
    private $ipGeoLocation;
    /** @var \Doctrine\ORM\EntityManager  */
    private $entityManager;

    public function __construct(\VstupniTest\Factory\IpGeoLocation $ipGeoLocation, \VstupniTest\Factory\DoctrineFactory $doctrineFactory)
    {
        $this->ipGeoLocation = $ipGeoLocation;
        $this->entityManager = $doctrineFactory->createEntityManagerBySettings();
    }

    public function getPointOfSalesCollection(): \VstupniTest\App\Entity\Collection\PointOfSaleCollection
    {
        $pointOfSaleRepository = $this->entityManager->getRepository(\PointsOfSale::class);
        $pointOfSales = $pointOfSaleRepository->findAll();
        return new \VstupniTest\App\Entity\Collection\PointOfSaleCollection($pointOfSales);
    }

    public function getPointOfSalesCollectionSettedDistance(string $ipAddress):  PointOfSaleCollection
    {
        $ipGeoResponse = $this->ipGeoLocation->getLocationByIpGeoLocation($ipAddress);
        $pointOfSales = $this->getPointOfSalesCollection();
        $ipAddressLat = $ipGeoResponse->getLat();
        $ipAddressLong = $ipGeoResponse->getLong();
        $pointOfSales->setDistance($ipAddressLat,$ipAddressLong);
        return  $pointOfSales;
    }





}
