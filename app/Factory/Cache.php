<?php declare(strict_types=1);


namespace VstupniTest\Factory;


class Cache
{
    /** @var \Nette\Caching\Cache */
    protected $cache;


    public function __construct(
        string $temporaryStorage='/tmp'
    )
    {
        $storage = new \Nette\Caching\Storages\FileStorage($temporaryStorage);
        $this->cache = new \Nette\Caching\Cache($storage);
    }

    public function getCache(): \Nette\Caching\Cache
    {
        return $this->cache;
    }

}
