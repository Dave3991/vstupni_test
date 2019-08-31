<?php declare(strict_types = 1);

namespace VstupniTest\App\Controller;

use Apitte\Core\Annotation\Controller\ControllerPath;
use Apitte\Core\Annotation\Controller\Method;
use Apitte\Core\Annotation\Controller\Path;
use Apitte\Core\Http\ApiRequest;
use Apitte\Core\Http\ApiResponse;
/**
 * @ControllerPath("/")
 */
final class HelloController extends BaseV1Controller
{
    /** @var \VstupniTest\Factory\IpGeoLocation  */
    private $ipGeoLocation;

    /** @var \VstupniTest\App\Factory\PointOfSaleFactory */
    private $pointOfSaleFactory;

    public function __construct(\VstupniTest\Factory\IpGeoLocation $ipGeoLocation,\VstupniTest\App\Factory\PointOfSaleFactory $pointOfSaleFactory)
    {
        $this->ipGeoLocation = $ipGeoLocation;
        $this->pointOfSaleFactory = $pointOfSaleFactory;
    }

    /**
     * @Path("/")
     * @Method("GET")
     */
    public function index(ApiRequest $request, ApiResponse $response): ApiResponse
    {
        return $response->writeJsonBody(['hello' => ['world']]);
    }
    /**
     * @Path("/pure")
     * @Method("GET")
     */
    public function pure(): array
    {
        return ['hello' => 'apitte'];
    }
    /**
     * @Path("/scalar")
     * @Method("GET")
     */
    public function scalar(): string
    {
        return 'OK';
    }
    /**
     * @Path("/ip")
     * @Method("GET")
     */
    public function ip()
    {
        return $this->getIpAddress();
    }

    /**
     * @Path("/ip-geo")
     * @Method("GET")
     */
    public function responseFromIpGeo(ApiRequest $request, ApiResponse $response)
    {
        $ipAddress = '185.32.182.6';
        $ipGeolocation = $this->ipGeoLocation->getLocationByIpGeoLocation($ipAddress);
        return $response->writeJsonBody($ipGeolocation->jsonSerialize());
    }

    /**
     * @Path("/distance")
     * @Method("GET")
     */
    public function sortedByDistance(ApiRequest $request, ApiResponse $response)
    {
        $ipAddress = '185.32.182.6';
        $pointOfSalesCollection = $this->pointOfSaleFactory->getPointOfSalesCollectionSettedDistance($ipAddress);
        $sortedByDistance = $pointOfSalesCollection->getSortedByDistance();
        return $response->writeJsonBody($sortedByDistance->getJson());

    }
    /**
     * @Path("/open")
     * @Method("GET")
     */
    public function onlyOpen(ApiRequest $request, ApiResponse $response)
    {
        $dateTime = new \DateTime('now');
        $pointOfSalesCollection = $this->pointOfSaleFactory->getPointOfSalesCollection();
        $onlyOpened = $pointOfSalesCollection->getOnlyOpened($dateTime);
        return $response->writeJsonBody($onlyOpened->getJson());
    }

    /**
     * @Path("/open-distance")
     * @Method("GET")
     */
    public function onlyOpenAndSortedByDistance(ApiRequest $request, ApiResponse $response)
    {
        $ipAddress = '185.32.182.6';
        $dateTime = new \DateTime('now');
        $pointOfSalesCollection = $this->pointOfSaleFactory->getPointOfSalesCollectionSettedDistance($ipAddress);
        $sortedByDistance = $pointOfSalesCollection->getSortedByDistance();
        $sortedyByDistanceOnlyOpened = $sortedByDistance->getOnlyOpened($dateTime);
        return $response->writeJsonBody($sortedyByDistanceOnlyOpened->getJson());
    }
}
