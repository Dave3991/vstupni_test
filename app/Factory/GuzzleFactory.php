<?php declare(strict_types=1);


namespace VstupniTest\Factory;


class GuzzleFactory
{

    public function createGuzzle(): \GuzzleHttp\Client
    {
        return new \GuzzleHttp\Client();
    }
}
