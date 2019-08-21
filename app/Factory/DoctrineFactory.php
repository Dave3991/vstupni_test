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

    /**
     * DoctrineFactory constructor.
     **/
    public function __construct(bool $debugMode, array $pathsToEntityFiles, string $driver,string $user, string $password, string $dbName)
    {
        $this->debugMode = $debugMode;
        $this->pathsToEntityFiles = $pathsToEntityFiles;
        $this->driver = $driver;
        $this->user = $user;
        $this->password = $password;
        $this->dbName = $dbName;
    }

    public function createEntityManagerBySettings(): \Doctrine\ORM\EntityManager
    {
        return $this->createEntityManager($this->debugMode,$this->pathsToEntityFiles,$this->driver,$this->user,$this->password,$this->dbName);
    }


    public function createEntityManager(bool $debugMode, array $pathsToEntityFiles, string $driver, string $user, string $password, string $dbName): \Doctrine\ORM\EntityManager
    {
        $dbParams = [
            'driver'   => $driver,
            'user'     => $user,
            'password' => $password,
            'dbname'   => $dbName,
        ];

        $config = Setup::createAnnotationMetadataConfiguration($pathsToEntityFiles, $debugMode);
        return EntityManager::create($dbParams, $config);
    }

}
