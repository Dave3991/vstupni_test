<?php declare(strict_types=1);


namespace VstupniTest\App\Entity\Collection;


class PointOfSaleCollection extends \ArrayObject
{
    /** @param \PointsOfSale $value */
    public function append($value)
    {
        parent::append($value);
    }

    public function setDistance(float $ipAddressLat, float $ipAddressLon): PointOfSaleCollection
    {
        $settedDistance = new self();
        /** @var \PointsOfSale $poinOfSale */
        foreach ($this as $poinOfSale)
        {
            $distance = $this->computeDistance($poinOfSale->getLat(), $poinOfSale->getLon(),$ipAddressLat,$ipAddressLon);
            $poinOfSale->setDistance($distance);
            $settedDistance->append($poinOfSale);
        }
        return $settedDistance;
    }

    public function getSortedByDistance(): PointOfSaleCollection
    {
        $iterator = $this->getIterator();
        $iterator->uasort(function ($a, $b) {
            /** @var \PointsOfSale  $a */
            /** @var \PointsOfSale  $b */
            return ($a->getDistance() < $b->getDistance()) ? -1 : 1;
        });
        return new static(\iterator_to_array($iterator));
    }

    public function getOnlyOpened(): PointOfSaleCollection
    {
        $onlyOpened = new self();
        /** @var \PointsOfSale $poinOfSale */
        foreach ($this as $poinOfSale)
        {
           $openingHoursCollection = $poinOfSale->getOpeningHours();
           dump(iterator_to_array($openingHoursCollection->getIterator()));
           exit;
        }
    }

    private function computeDistance(float $lat1, float $lon1, float $lat2, float $lon2): float
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
