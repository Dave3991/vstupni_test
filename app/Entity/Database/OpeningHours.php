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
     * @var \DateTime
     */
    private $computeDate;

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
     * @param $date ve ktery den chceme vedet od kdy je otevreno
     * @return \DateTime
     */
    public function getOpenFrom(\DateTime $date): \DateTime
    {
        $day = $this->getDayId();
        $dayofweek = $date->format('w');
        $result = new DateTime('now');
        $result->setTimestamp(strtotime(($day - $dayofweek).' day', $date->getTimestamp()));
        $this->openFrom->setDate((int)$result->format('Y'),(int)$result->format('m'),(int)$result->format('d'));
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
     * @param $date ve ktery den chceme vedet do kdy je otevreno
     * @return \DateTime
     */
    public function getOpenTo(\DateTime $date): \DateTime
    {
        $day = $this->getDayId();
        $dayofweek = $date->format('w');
        $result = new DateTime('now');
        $result->setTimestamp(strtotime(($day - $dayofweek).' day', $date->getTimestamp()));
        $this->openTo->setDate((int)$result->format('Y'),(int)$result->format('m'),(int)$result->format('d'));
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
     * @param \PointsOfSale $pointOfSale
     */
    public function setPointOfSaleId(\PointsOfSale $pointOfSale): void
    {
        $this->pointOfSaleId = $pointOfSale;
    }

    public function jsonSerialize()
    {
        $date = new \DateTime('now');
        if($this->computeDate !== null)
        {
            $date = $this->computeDate;
        }
        return
        [
            'openFrom' => $this->getOpenFrom($date),
            'openTo' => $this->getOpenTo($date),
        ];
    }


}
