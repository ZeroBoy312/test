<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DeliveryRepository")
 */
class Delivery
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private int $id;

    /**
     * @ORM\Column(type="string")
     */
    private string $name;

    /**
     * @ORM\ManyToOne(targetEntity="Product", cascade={"all"})
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    private Product $product;

    /**
     * @ORM\Column(type="integer")
     */
    private int $count;

    /**
     * @ORM\Column(type="integer")
     */
    private int $balance;

    /**
     * @ORM\Column(type="integer")
     */
    private int $cost;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTime $date;

    public function __construct()
    {
        $this->balance = $this->count;
        $this->date = new \DateTime();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
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
     * @return Delivery
     */
    public function setName(string $name): Delivery
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * @param Product $product
     * @return Delivery
     */
    public function setProduct(Product $product): Delivery
    {
        $this->product = $product;

        return $this;
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @param int $count
     * @return Delivery
     */
    public function setCount(int $count): Delivery
    {
        $this->count = $count;

        return $this;
    }

    /**
     * @return int
     */
    public function getBalance(): int
    {
        return $this->balance;
    }

    /**
     * @param int $balance
     * @return Delivery
     */
    public function setBalance(int $balance): Delivery
    {
        $this->balance = $balance;

        return $this;
    }

    /**
     * @return int
     */
    public function getCost(): int
    {
        return $this->cost;
    }

    /**
     * @param int $cost
     * @return Delivery
     */
    public function setCost(int $cost): Delivery
    {
        $this->cost = $cost;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     * @return Delivery
     */
    public function setDate(\DateTime $date): Delivery
    {
        $this->date = $date;

        return $this;
    }
}