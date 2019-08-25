<?php declare(strict_types=1);



use Doctrine\ORM\Mapping as ORM;

/**
 * OpeningHours
 *
 * @ORM\Table(name="opening_hours", indexes={@ORM\Index(name="FK_opening_hours_points_of_sale", columns={"point_of_sale_id"})})
 * @ORM\Entity
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
     * @var bool
     *
     * @ORM\Column(name="day_id", type="boolean", nullable=false)
     */
    private $dayId;

    /**
     * @var \PointsOfSale
     *
     * @ORM\ManyToOne(targetEntity="PointsOfSale")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="point_of_sale_id", referencedColumnName="point_of_sale_id")
     * })
     */
    private $pointOfSale;


}
