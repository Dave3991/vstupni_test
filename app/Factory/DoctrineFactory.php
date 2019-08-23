<?php declare(strict_types=1);


namespace VstupniTest\Factory;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

class DoctrineFactory
{
    /** @var bool */
    protected  $debugMode;
    /** @var string[] */
    protected  $pathsToEntityFiles;
    /** @var string */
    protected  $driver;
    /** @var string  */
    protected $user;
    /** @var string */
    protected  $password;
    /** @var string */
    protected  $dbName;
    /** @var string */
    protected $host;

    /**
     * DoctrineFactory constructor.
     **/
    public function __construct(bool $debugMode, array $pathsToEntityFiles, string $driver,string $user, string $password, string $dbName, string $host)
    {
        $this->debugMode = $debugMode;
        $this->pathsToEntityFiles = $pathsToEntityFiles;
        $this->driver = $driver;
        $this->user = $user;
        $this->password = $password;
        $this->dbName = $dbName;
        $this->host = $host;
    }

    public function createEntityManagerBySettings(): \Doctrine\ORM\EntityManager
    {
        return $this->createEntityManager($this->debugMode,$this->pathsToEntityFiles,$this->driver,$this->user,$this->password,$this->dbName, $this->host);
    }


    public function createEntityManager(bool $debugMode, array $pathsToEntityFiles, string $driver, string $user, string $password, string $dbName, string $host): \Doctrine\ORM\EntityManager
    {
        $dbParams = [
            'driver'   => $driver,
            'user'     => $user,
            'password' => $password,
            'dbname'   => $dbName,
            'host'     => $host
        ];

        $config = Setup::createAnnotationMetadataConfiguration($pathsToEntityFiles, $debugMode);
        return EntityManager::create($dbParams, $config);
    }

}
