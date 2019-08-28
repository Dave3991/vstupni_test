<?php declare(strict_types=1);


namespace VstupniTest\Factory;



class IpGeoLocation
{
    public const APIKEY = '41bd7d7551154ec290bdc1ad7cf52dce';

    /** @var \GuzzleHttp\Client */
    protected $guzzleClient;

    /** @var \VstupniTest\Factory\Cache  */
    protected $cache;

    public function __construct(GuzzleFactory $guzzleFactory, Cache $cache)
    {
        $this->guzzleClient = $guzzleFactory->createGuzzle();
        $this->cache = $cache->getCache();
    }

    /**
     * @param string $ipAddress
     *
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     *  //curl 'https://api.ipgeolocation.io/ipgeo?apiKey=API_KEY&ip=1.1.1.1'
     */
    public function getLocationByIpGeoLocation(string $ipAddress): \VstupniTest\App\Entity\IpGeoLocation
    {
        $cachedValue = $this->cache->load($ipAddress);
        if($cachedValue !== null)
        {
            return $cachedValue;
        }
        $request = $this->guzzleClient->request('get','https://api.ipgeolocation.io/ipgeo' ,
            [
                'query' =>
                    [
                        'apiKey' => self::APIKEY,
                        'ip' => $ipAddress,
                    ],
            ]);
        $reponse =  $request->getBody()->getContents();
        $ipGeoLocation = new \VstupniTest\App\Entity\IpGeoLocation($reponse);
        $this->cache->save($ipAddress,$ipGeoLocation);
        return $ipGeoLocation;
    }


}
