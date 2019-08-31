<?php declare(strict_types=1);



use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;

/**
 * OpeningHours
 *
 * @ORM\Entity
 * @ORM\Table(name="opening_hours", indexes={@ORM\Index(name="FK_opening_hours_points_of_sale", columns={"point_of_sale_id"})})
 *
 */
class OpeningHours implements JsonSerializable
{
    /**
     * @var int
     *
     * @ORM\Column(name="opening_hours_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $openingHoursId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="open_from", type="time", nullable=false)
     */
    private $openFrom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="open_to", type="time", nullable=false)
     */
    private $openTo;

    /**
     * @var int
     *
     * @ORM\Column(name="day_id", type="smallint", nullable=false)
     */
    private $dayId;

    /**
     * @var string
     * @ManyToOne(targetEntity="PointsOfSale", inversedBy="openingHours")
     * @ORM\JoinColumn(name="point_of_sale_id", referencedColumnName="point_of_sale_id")
     */
    private $pointOfSaleId;

    /**
     * datum pro ktere pocitame zda je otevreno nebo ne
     * @var ?\DateTime
     */
    private $computeDate = null;

    /**
     * OpeningHours constructor.
     *
     * @param int       $openingHoursId
     * @param \DateTime $openFrom
     * @param \DateTime $openTo
     * @param int       $dayId
     * @param string    $pointOfSaleId
     */
    public function __construct(int $openingHoursId, \DateTime $openFrom, \DateTime $openTo, int $dayId, string $pointOfSaleId)
    {
        $this->openingHoursId = $openingHoursId;
        $this->openFrom = $openFrom;
        $this->openTo = $openTo;
        $this->dayId = $dayId;
        $this->pointOfSaleId = $pointOfSaleId;
    }

    /**
     * @param \DateTime $computeDate
     */
    public function setComputeDate(\DateTime $computeDate): void
    {
        $this->computeDate = $computeDate;
    }


    /**
     * @return int
     */
    public function getOpeningHoursId(): int
    {
        return $this->openingHoursId;
    }

    /**
     * @param int $openingHoursId
     */
    public function setOpeningHoursId(int $openingHoursId): void
    {
        $this->openingHoursId = $openingHoursId;
    }

    /**
     * $date ve ktery den chceme vedet od kdy je otevreno
     * @return \DateTime
     */
    public function getOpenFrom(?\DateTime $date = null): ?\DateTime
    {
        if($date === null)
        {
            return $this->openFrom;
        }
        $day = $this->getDayId();
        $dayofweek = (int)$date->format('w');// w = 0 (for Sunday) through 6 (for Saturday), N = 1 (for Monday) through 7 (for Sunday)
        //pokud tato entita neudrzuje informaci o dnu v tydnu o ktery se zajimame vracime null
        if($day !== $dayofweek)
        {
            return null;
        }
        //v opacnem pripade nastavujeme datum ktere nas zajima abychom nevraci 1970-01-01
        $this->openFrom->setDate((int)$date->format('Y'),(int)$date->format('m'),(int)$date->format('d'));
        return $this->openFrom;
    }

    /**
     * @param \DateTime $openFrom
     */
    public function setOpenFrom(\DateTime $openFrom): void
    {
        $this->openFrom = $openFrom;
    }

    /**
     * $date ve ktery den chceme vedet do kdy je otevreno
     * @return \DateTime
     */
    public function getOpenTo(?\DateTime $date = null): ?\DateTime
    {
        if($date === null)
        {
            return $this->openTo;
        }
        $day = $this->getDayId();
        $dayofweek = (int)$date->format('w');// w = 0 (for Sunday) through 6 (for Saturday), N = 1 (for Monday) through 7 (for Sunday)
        //pokud tato entita neudrzuje informaci o dnu v tydnu o ktery se zajimame vracime null
        if($day !== $dayofweek)
        {
            return null;
        }
        $this->openTo->setDate((int)$date->format('Y'),(int)$date->format('m'),(int)$date->format('d'));
        return $this->openTo;
    }

    /**
     * @param \DateTime $openTo
     */
    public function setOpenTo(\DateTime $openTo): void
    {
        $this->openTo = $openTo;
    }

    /**
     * @return int
     */
    public function getDayId(): int
    {
        return $this->dayId;
    }

    /**
     * @param int $dayId
     */
    public function setDayId(int $dayId): void
    {
        $this->dayId = $dayId;
    }

    /**
     * @return string
     */
    public function getPointOfSaleId(): string
    {
        return $this->pointOfSaleId;
    }

    /**
     * @param string $pointOfSale
     */
    public function setPointOfSaleId(string $pointOfSale): void
    {
        $this->pointOfSaleId = $pointOfSale;
    }

    public function jsonSerialize()
    {
        return
        [
            'openFrom' => $this->getOpenFrom($this->computeDate),
            'openTo' => $this->getOpenTo($this->computeDate),
        ];
    }


}
