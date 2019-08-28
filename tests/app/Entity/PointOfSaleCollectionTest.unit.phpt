<?php declare(strict_types=1);


namespace VstupniTest\Tests\App\Entity\Collection;

require __DIR__ . '/../../../vendor/autoload.php';

\Tester\Environment::setup();

use Tester\Assert;

class PointOfSaleCollectionTest extends \Tester\TestCase
{
    /** @var \PointsOfSale[] */
    private $pointOfSales;

    public function setUp()
    {
        $openingHours = new \Doctrine\Common\Collections\Collection();
        $this->pointOfSales =
            [
                0 => new \PointsOfSale('0','type01','pos01','adressa01',50.2106,15.3002,1253376,3,null,$openingHours),
                1 => new \PointsOfSale('0','type01','pos01','adressa01',50.2106,15.3002,1253376,3,null,$openingHours)
            ];
    }

    public function testSetDistance()
    {
        $poinOfSaleCollection = new \VstupniTest\App\Entity\Collection\PointOfSaleCollection();
        $poinOfSaleCollection->append($this->pointOfSales);
        dump($poinOfSaleCollection);
        exit;

    }

    public function testGetOnlyOpened()
    {

    }

    public function testGetSortedByDistance()
    {

    }
}

$testCase = new PointOfSaleCollectionTest();
$testCase->run();
