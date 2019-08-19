<?php declare(strict_types=1);


namespace VstupniTest\Data\DataProvider;


class DatabaseParametersProvider
{
    private $containerParametersProvider;

    public function __construct(ContainerParametersProvider $containerParametersProvider)
    {
        $this->containerParametersProvider = $containerParametersProvider;
    }

    public function getDatabaseParameters(): array
    {
        return $this->containerParametersProvider->getContainerParameters()['database'];
    }

    public function getDriver(): string
    {
        return $this->getDatabaseParameters()['driver'];
    }

    public function getUser(): string
    {
        return $this->getDatabaseParameters()['user'];
    }

    public function getPassword(): string
    {
        return $this->getDatabaseParameters()['password'];
    }

    public function getPathToEntityFiles(): string
    {
        return $this->getDatabaseParameters()['pathToEntityFiles'];
    }

    public function getDbName(): string
    {
        return $this->getDatabaseParameters()['dbname'];
    }

    public function getDsn(): string
    {
        return $this->getDatabaseParameters()['dsn'];
    }
}