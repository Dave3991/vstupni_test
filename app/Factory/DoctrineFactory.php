<?php declare(strict_types=1);


namespace VstupniTest\Factory;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

class DoctrineFactory
{
    /** @var \VstupniTest\Data\DataProvider\DatabaseParametersProvider  */
    protected $databaseParametersProvider;

    /** @var \VstupniTest\Data\DataProvider\ContainerParametersProvider  */
    protected $containerParametersProvider;

    public function __construct(
        \VstupniTest\Data\DataProvider\DatabaseParametersProvider $databaseParametersProvider,
        \VstupniTest\Data\DataProvider\ContainerParametersProvider $containerParametersProvider
    )
    {
        $this->databaseParametersProvider = $databaseParametersProvider;
        $this->containerParametersProvider = $containerParametersProvider;
    }

    public function getEntityManager(): \Doctrine\ORM\EntityManager
    {
        $isDevMode = $this->containerParametersProvider->getDebugMode();
        $pathsToEntityFiles = [
            $this->databaseParametersProvider->getPathToEntityFiles(),
        ];

        $driver = $this->databaseParametersProvider->getDriver();
        $user = $this->databaseParametersProvider->getUser();
        $password = $this->databaseParametersProvider->getPassword();
        $dbname = $this->databaseParametersProvider->getDbName();

        return $this->createEntityManager($isDevMode, $pathsToEntityFiles, $driver, $user, $password, $dbname);
    }

    protected function createEntityManager(bool $debugMode, array $pathsToEntityFiles, string $driver, string $user, string $password, string $dbName): \Doctrine\ORM\EntityManager
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