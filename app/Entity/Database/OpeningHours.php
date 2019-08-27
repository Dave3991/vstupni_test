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
class OpeningHours
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
     * @var \PointsOfSale
     * @ManyToOne(targetEntity="PointsOfSale", inversedBy="openingHours")
     * @ORM\JoinColumn(name="point_of_sale_id", referencedColumnName="point_of_sale_id")
     */
    private $pointOfSaleId;

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
     * @return \DateTime
     */
    public function getOpenFrom(): \DateTime
    {
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
     * @return \DateTime
     */
    public function getOpenTo(): \DateTime
    {
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
     * @return \PointsOfSale
     */
    public function getPointOfSaleId(): \PointsOfSale
    {
        return $this->pointOfSale;
    }

    /**
     * @param \PointsOfSale $pointOfSale
     */
    public function setPointOfSaleId(\PointsOfSale $pointOfSale): void
    {
        $this->pointOfSaleId = $pointOfSale;
    }



}
