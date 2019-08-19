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
    /** @var string */
    protected  $password;
    /** @var string */
    protected  $dbName;

    /**
     * DoctrineFactory constructor.
     *
     * @param bool     $debugMode
     * @param string[] $pathsToEntityFiles
     * @param string   $driver
     * @param string   $password
     * @param string   $dbName
     */
    public function __construct(bool $debugMode, array $pathsToEntityFiles, string $driver, string $password, string $dbName)
    {
        $this->debugMode = $debugMode;
        $this->pathsToEntityFiles = $pathsToEntityFiles;
        $this->driver = $driver;
        $this->password = $password;
        $this->dbName = $dbName;
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
