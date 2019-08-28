<?php declare(strict_types=1);



use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;

/**
 * PointsOfSale
 *
 * @ORM\Entity
 * @ORM\Table(name="points_of_sale")
 *
 */
class PointsOfSale implements JsonSerializable
{
    /**
     * @var string
     *
     * @ORM\Column(name="point_of_sale_id", type="string", length=50, nullable=false)
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\Id
     *
     */
    private $pointOfSaleId;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=50, nullable=false)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255, nullable=false)
     */
    private $address;

    /**
     * @var float
     *
     * @ORM\Column(name="lat", type="decimal", precision=10, scale=10, nullable=false)
     */
    private $lat;

    /**
     * @var float
     *
     * @ORM\Column(name="lon", type="decimal", precision=10, scale=10, nullable=false)
     */
    private $lon;

    /**
     * @var int
     *
     * @ORM\Column(name="services", type="integer", nullable=false)
     */
    private $services;

    /**
     * @var int
     *
     * @ORM\Column(name="pay_methods", type="integer", nullable=false)
     */
    private $payMethods;

    /**
     * Vzdalenost k IP adrese
     * @var ?float
     */
    private $distance;

    /**
     * One Point of Sale has many openingHours
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\OneToMany(targetEntity="OpeningHours",mappedBy="pointOfSaleId")
     */
    private $openingHours;


    /**
    * PointsOfSale constructor.
    *
    * @param string $pointOfSaleId
    * @param string $type
    * @param string $name
    * @param string $address
    * @param float $lat
    * @param float $lon
    * @param int $services
    * @param int $payMethods
    * @param ?float $distance
    * @param \Doctrine\Common\Collections\Collection $openingHours
    */public function __construct(string $pointOfSaleId, string $type, string $name, string $address, float $lat, float $lon, int $services, int $payMethods, ?float $distance, \Doctrine\Common\Collections\Collection $openingHours)
    {
        $this->pointOfSaleId = $pointOfSaleId;
        $this->type = $type;
        $this->name = $name;
        $this->address = $address;
        $this->lat = $lat;
        $this->lon = $lon;
        $this->services = $services;
        $this->payMethods = $payMethods;
        $this->distance = $distance;
        $this->openingHours = $openingHours;
    }


    /**
     * @return string
     */
    public function getPointOfSaleId(): string
    {
        return $this->pointOfSaleId;
    }

    /**
     * @param string $pointOfSaleId
     */
    public function setPointOfSaleId(string $pointOfSaleId): void
    {
        $this->pointOfSaleId = $pointOfSaleId;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    /**
     * @return float
     */
    public function getLat(): float
    {
        return (float)$this->lat;
    }

    /**
     * @param float $lat
     */
    public function setLat(float $lat): void
    {
        $this->lat = $lat;
    }

    /**
     * @return float
     */
    public function getLon(): float
    {
        return (float)$this->lon;
    }

    /**
     * @param float $lon
     */
    public function setLon(float $lon): void
    {
        $this->lon = $lon;
    }

    /**
     * @return int
     */
    public function getServices(): int
    {
        return $this->services;
    }

    /**
     * @param int $services
     */
    public function setServices(int $services): void
    {
        $this->services = $services;
    }

    /**
     * @return int
     */
    public function getPayMethods(): int
    {
        return $this->payMethods;
    }

    /**
     * @param int $payMethods
     */
    public function setPayMethods(int $payMethods): void
    {
        $this->payMethods = $payMethods;
    }

    /**
     * @return float
     */
    public function getDistance(): ?float
    {
        return $this->distance;
    }

    /**
     * @param float $distance
     */
    public function setDistance(float $distance): void
    {
        $this->distance = $distance;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOpeningHours(): \Doctrine\Common\Collections\Collection
    {
        return $this->openingHours;
    }

    public function jsonSerialize()
    {
        $objectVars =  \get_object_vars($this);
        $openingHoursCollection = $this->getOpeningHours();
        $openFromOpenTo = [];
        /** @var \OpeningHours $openingHours */
        foreach ($openingHoursCollection as $openingHours)
        {
            $openFromOpenTo[] = $openingHours->jsonSerialize();
        }
        $objectVars['openingHours'] = $openFromOpenTo;
        return $objectVars;
    }


}
