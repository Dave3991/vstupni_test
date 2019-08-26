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

    public function getPointOfSaleCollection(): \Doctrine\Common\Collections\ArrayCollection
    {
        $pointOfSaleRepository = $this->entityManager->getRepository(\PointsOfSale::class);
        $products = $pointOfSaleRepository->findAll();
        return new \Doctrine\Common\Collections\ArrayCollection($products);
    }

    public function getSordetByDistance(string $ipAddress):  \Doctrine\Common\Collections\ArrayCollection
    {
        $ipGeoResponse = $this->ipGeoLocation->getLocationByIpGeoLocation($ipAddress);
        $decodedResponse = $this->decodeJson($ipGeoResponse);
        $ipAddressLat = $this->parseLatFromResponse($decodedResponse);
        $ipAddressLong = $this->parseLongFromResponse($decodedResponse);
        $collection = $this->getPointOfSaleCollection();
        $iterator = $collection->getIterator();
        /** @var \PointsOfSale $pointOfSale */
        $pointOfSale = $iterator->current();

        $posLat = $pointOfSale->getLat();
        $posLong = $pointOfSale->getLon();

        $distance = $this->computeDistance($ipAddressLat,$ipAddressLong,$posLat,$posLong);
        $pointOfSale->setDistance($distance);
        $iterator->uasort(function ($a, $b) {
            return ($a->getDistance() < $b->getDistance()) ? -1 : 1;
        });
         $collection = new \Doctrine\Common\Collections\ArrayCollection(iterator_to_array($iterator));
         dump($collection);
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

    public function computeDistance(float $lat1, float $lon1, float $lat2, float $lon2): float
    {
        if (($lat1 == $lat2) && ($lon1 == $lon2)) {
            return 0.0;
        } else {
            $theta = $lon1 - $lon2;
            $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $kilometers = $dist * 60 * 1.1515 * 1.609344;
            return $kilometers;
        }
    }
}
