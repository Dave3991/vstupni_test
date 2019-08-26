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

    /** @var \App\Model\Distance */
    private $distance;

    public function __construct(\VstupniTest\Factory\IpGeoLocation $ipGeoLocation,\VstupniTest\App\Model\Distance $distance)
    {
        $this->ipGeoLocation = $ipGeoLocation;
        $this->distance = $distance;
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
    public function responseFromIpGeo()
    {
        $ipAddress = '185.32.182.6';
        return $this->ipGeoLocation->getLocationByIpGeoLocation($ipAddress);
    }

    /**
     * @Path("/sorted")
     * @Method("GET")
     */
    public function sortedCollection()
    {
        $ipAddress = '185.32.182.6';
        $collection = $this->distance->getSordetByDistance($ipAddress);
        return dump($collection,true);
    }
}
