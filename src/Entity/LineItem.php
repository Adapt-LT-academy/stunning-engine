<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity
 */
class LineItem extends Item
{

  /**
   * Many LineItems have One Order.
   * @ORM\ManyToOne(targetEntity="Order", inversedBy="items", cascade={"persist"})
   * @ORM\JoinColumn(name="order_id", referencedColumnName="id")
   */
    private $order;

    /**
     * @return Order
     */
    public function getOrder(): Order
    {
        return $this->order;
    }

    /**
     * @param Order $order
     *
     * @return $this
     */
    public function setOrder(Order $order): self
    {
        $this->order = $order;

        return $this;
    }

}
