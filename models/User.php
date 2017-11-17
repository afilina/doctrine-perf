<?php
namespace DoctrinePerformance;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class User
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
    public $firstName;

    /**
     * @ORM\Column(type="string")
     */
    public $lastName;

    /**
     * @ORM\Column(type="string")
     */
    public $email;

    /**
     * @ORM\ManyToOne(targetEntity="Address", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="billing_address_id", referencedColumnName="id")
     */
    public $billingAddress;

    /**
     * @ORM\ManyToOne(targetEntity="Address", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="billing_address_id", referencedColumnName="id")
     */
    public $shippingAddress;

    /**
     * @ORM\ManyToOne(targetEntity="User", cascade={"persist"})
     * @ORM\JoinColumn(name="sales_rep_id", referencedColumnName="id")
     */
    public $salesRep;

    /**
     * @ORM\OneToMany(targetEntity="CustomProperty", mappedBy="user", cascade={"persist", "remove"})
     */
    public $customProperties;

    public function getMailToTag()
    {
        return sprintf('<a href="mailto:%1$s">%1$s</a>', $this->email);
    }
}
