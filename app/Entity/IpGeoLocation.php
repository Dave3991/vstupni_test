<?php declare(strict_types=1);


namespace VstupniTest\App\Entity;


class IpGeoLocation
{
    private $contentFromApi;

    public function __construct(string $contentFromApi)
    {
        $this->contentFromApi = $this->decodeJson($contentFromApi);
    }

    public function getLat(): float
    {
        return (float)$this->contentFromApi['latitude'];
    }

    public function getLong(): float
    {
        return (float)$this->contentFromApi['longitude'];
    }

    private function decodeJson(string $contentFromApi): array
    {
        return \json_decode($contentFromApi,true);
    }

}
