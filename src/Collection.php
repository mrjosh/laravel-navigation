<?php

namespace Josh\Components\Navigation;

class Collection
{
    /**
     * Collection name
     *
     * @var string
     */
    protected $name;

    /**
     * Collection items
     *
     * @var array
     */
    protected $items = [];

    /**
     * Collection constructor.
     *
     * @param $name
     */
    public function __construct($name = null)
    {
        $this->setName($name);
    }

    /**
     * Add item to collection
     *
     * @param Item $item
     * @return $this
     */
    public function add(Item $item)
    {
        $this->items[] = $item;

        return $this;
    }

    /**
     * get collection items
     *
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Get collection name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set collection name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
}