<?php declare(strict_types=1);


namespace VstupniTest\Data\DataProvider;


class ContainerParametersProvider
{
    /**
     * @var \Nette\DI\Container
     */
    protected $container;

    public function __construct(\Nette\DI\Container $container)
    {
        $this->container = $container;
    }

    /**
     * @return mixed[]
     */
    public function getContainerParameters(): array
    {
        return $this->container->getParameters();
    }

    public function getDebugMode(): bool
    {
        return $this->getContainerParameters()['debugMode'];
    }

}