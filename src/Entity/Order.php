<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity
 * @ORM\Table(name="orders")
 */
class Order
{

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     *
     */
    protected $id;

    /**
     * One Order has Many Line Items.
     * @ORM\OneToMany(targetEntity="LineItem", mappedBy="order", cascade={"persist"})
     */
    protected $items;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", length=11)
     */
    protected $total = 0;

    public function __construct()
    {
        $this->items = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return $this
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getItems(): ?ArrayCollection
    {
        return $this->items;
    }

    /**
     * @param LineItem $item
     *
     * @return $this
     */
    public function addItem(LineItem $item): self
    {
        $this->items[] = $item;

        return $this;
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * @param int $total
     *
     * @return $this
     */
    public function setTotal(int $total): self
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Add line item to order.
     *
     * @param \App\Entity\Item $item
     *   Item to add in order.
     */
    public function addLineItemToOrder(Item $item): void
    {
        $lineItem = new LineItem();
        $lineItem->setSize($item->getSize());
        $lineItem->setType($item->getType());
        $lineItem->setPrice($item->getPrice());
        $lineItem->setName($item->getName());
        $lineItem->setOrder($this);
        $this->addItem($lineItem);
    }

    /**
     * Calculate and set order total using it's products.
     */
    public function calculateTotal()
    {
        $total = 0;
        foreach ($this->items as $item) {
            $total = bcadd($total, $item->getPrice());
        }
        $this->setTotal($total);
    }

}
