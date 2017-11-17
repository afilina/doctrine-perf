<?php
namespace DoctrinePerformance;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Address
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    public $id;

    /**
     * @ORM\Column(type="string")
     */
    public $address;

    /**
     * @ORM\Column(type="string")
     */
    public $city;

    /**
     * @ORM\Column(type="string")
     */
    public $country;
}
