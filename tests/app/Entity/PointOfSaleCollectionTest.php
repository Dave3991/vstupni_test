<?php declare(strict_types=1);


namespace VstupniTest\Tests\App\Entity\Collection;

require  './../../../vendor/autoload.php';
require  './../../../app/Entity/Database/OpeningHours.php';
require  './../../../app/Entity/Database/PointsOfSale.php';
require  './../../../app/Entity/Collection/PointOfSaleCollection.php';

//\Tester\Environment::setup();

use Tester\Assert;

class PointOfSaleCollectionTest extends \Tester\TestCase
{
    /** @var \PointsOfSale[] */
    private $pointOfSales;

    public function setUp()
    {
        $dateTime0From = $this->prepareDateTime('8:00:00');
        $dateTime0To = $this->prepareDateTime('20:00:00');

        $dateTime1From = $this->prepareDateTime('9:00:00');
        $dateTime1To = $this->prepareDateTime('10:00:00');

        //otevreno vzdy krome nedele
        $openingHoursSetupWholeWeek = [
         // 0 => new \OpeningHours(0,$dateTime0From,$dateTime0To,0,'0'),
          1 => new \OpeningHours(1,$dateTime0From,$dateTime0To,1,'0'),
          2 => new \OpeningHours(1,$dateTime0From,$dateTime0To,2,'0'),
          3 => new \OpeningHours(1,$dateTime0From,$dateTime0To,3,'0'),
          4 => new \OpeningHours(1,$dateTime0From,$dateTime0To,4,'0'),
          5 => new \OpeningHours(1,$dateTime0From,$dateTime0To,5,'0'),
          6 => new \OpeningHours(1,$dateTime0From,$dateTime0To,6,'0'),
        ];

        $openingHoursSetupClosed = [
            0 => new \OpeningHours(0,$dateTime1From,$dateTime1To,0,'1'), //otevreno jen v nedeli
        ];

        $openingHoursWholeWeek = $this->prepareOpeninHoursColletion($openingHoursSetupWholeWeek);

        $openingHoursClosed = $this->prepareOpeninHoursColletion($openingHoursSetupClosed);

        $this->pointOfSales =
            [
                0 => new \PointsOfSale('0','type01','pos01','adressa01',50.2106,15.3002,1253376,3,null,$openingHoursWholeWeek),
                1 => new \PointsOfSale('1','type02','pos02','adressa02',50.4416,15.1323,1253376,3,null,$openingHoursClosed)
            ];
    }

    public function testGetSortedByDistance()
    {
        $poinOfSaleCollection = new \VstupniTest\App\Entity\Collection\PointOfSaleCollection();
        foreach ($this->pointOfSales as $pointsOfSale) {
            $poinOfSaleCollection->append($pointsOfSale);
        }

        $poinOfSaleCollection->setDistance(50.51450,16.01190);
        $poinOfSaleCollection = $poinOfSaleCollection->getSortedByDistance();
        $nearestPoS = $poinOfSaleCollection->offsetGet(0);
        Assert::equal($this->pointOfSales[0],$nearestPoS);

    }

    public function testGetOnlyOpened()
    {
        $poinOfSaleCollection = new \VstupniTest\App\Entity\Collection\PointOfSaleCollection();
        foreach ($this->pointOfSales as $pointsOfSale) {
            $poinOfSaleCollection->append($pointsOfSale);
        }
        $testedDateTime = \DateTime::createFromFormat('Y-m-d H:i:s', '2019-09-01 09:30:00');
        $testedDateTimeClosed = \DateTime::createFromFormat('Y-m-d H:i:s', '2019-09-01 10:01:00');

        $poinOfSaleOpenedSunday = $poinOfSaleCollection->getOnlyOpened($testedDateTime);
        $poinOfSaleClosed = $poinOfSaleCollection->getOnlyOpened($testedDateTimeClosed);

        $pointsOfSaleOpened = $poinOfSaleOpenedSunday->offsetGet(0);
        $pointOfSaleClosed = $poinOfSaleClosed->offsetGet(0);

        Assert::equal($this->pointOfSales[1],$pointsOfSaleOpened);
        Assert::equal(null,$pointOfSaleClosed);
    }

    /**
     * @param string $time -> "08:00:00","20:00:00"
     */
    private function prepareDateTime(string $time): \DateTime
    {
        return \DateTime::createFromFormat('H:i:s', $time);
    }

    private function prepareOpeninHoursColletion(array $openinHoursSetup): \Doctrine\Common\Collections\ArrayCollection
    {
        $openinHoursCollection = new \Doctrine\Common\Collections\ArrayCollection();
        foreach ($openinHoursSetup as $openingHours) {
            $openinHoursCollection->add($openingHours);
        }
        return $openinHoursCollection;
    }

}

$testCase = new PointOfSaleCollectionTest();
$testCase->run();
