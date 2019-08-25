<?php declare(strict_types=1);



use Doctrine\ORM\Mapping as ORM;

/**
 * PointsOfSale
 *
 * @ORM\Table(name="points_of_sale")
 * @ORM\Entity
 */
class PointsOfSale
{
    /**
     * @var string
     *
     * @ORM\Column(name="point_of_sale_id", type="string", length=50, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
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
     * @ORM\Column(name="address", type="string", length=50, nullable=false)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="lat", type="decimal", precision=10, scale=10, nullable=false)
     */
    private $lat;

    /**
     * @var string
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


}
