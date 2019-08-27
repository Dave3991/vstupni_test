<?php declare(strict_types=1);


namespace VstupniTest\App\Model;


class Distance
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

    public function getPointOfSales(): \VstupniTest\App\Entity\Collection\PointOfSaleCollection
    {
        $pointOfSaleRepository = $this->entityManager->getRepository(\PointsOfSale::class);
        $pointOfSales = $pointOfSaleRepository->findAll();
        return new \VstupniTest\App\Entity\Collection\PointOfSaleCollection($pointOfSales);
    }

    public function getSordetByDistance(string $ipAddress):  \Doctrine\Common\Collections\ArrayCollection
    {
        $ipGeoResponse = $this->ipGeoLocation->getLocationByIpGeoLocation($ipAddress);
        $decodedResponse = $this->decodeJson($ipGeoResponse);
        $ipAddressLat = $this->parseLatFromResponse($decodedResponse);
        $ipAddressLong = $this->parseLongFromResponse($decodedResponse);
        $pointOfSales = $this->getPointOfSales();
        $pointOfSales->setDistance($ipAddressLat,$ipAddressLong);
        $pointOfSales->getSortedByDistance();
        $pointOfSales->getOnlyOpened();
        $iterator = $pointOfSales->getIterator();
        $collection = new \Doctrine\Common\Collections\ArrayCollection(iterator_to_array($iterator));
        return  $collection;
    //   return $this->computeDistance($ipAddressLat,$ipAddressLong,$pointsOfSale->getLat(),$pointsOfSale->getLon());

    }

    private function decodeJson($json): array
    {
        return \json_decode($json,true);
    }

    private function parseLongFromResponse($decodedResponse): float
    {
        return (float)$decodedResponse['longitude'];
    }

    private function parseLatFromResponse($decodedResponse): float
    {
        return (float)$decodedResponse['latitude'];
    }


}
