<?php
namespace DoctrinePerformance;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class CustomProperty
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
    public $name;

    /**
     * @ORM\Column(type="string")
     */
    public $value;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="customProperties")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    public $user;
}
