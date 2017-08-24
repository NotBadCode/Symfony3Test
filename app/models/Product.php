<?php

namespace app\models;

/**
 * Class Product
 * @Entity @Table(name="products")
 */
class Product
{
    /**
     * @var integer
     * @Id @Column(type="integer") @GeneratedValue
     */
    protected $id;

    /**
     * @var string
     * @Column(type="string")
     */
    protected $title;

    /**
     * @var float
     * @Column(type="decimal")
     */
    protected $price;

    /**
     * @var integer
     * @Column(type="integer")
     */
    protected $category_id;

    /**
     * @param integer $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @param float $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param integer $categoryId
     */
    public function setCategoryId($categoryId)
    {
        $this->category_id = $categoryId;
    }

    /**
     * @return integer
     */
    public function getCategoryId()
    {
        return $this->category_id;
    }
}