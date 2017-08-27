<?php

namespace app\models;


/**
 * Class Product
 * @Entity @Table(name="products_category")
 */
class ProductCategory
{
    /**
     * @var integer
     * @Id @Column(type="integer") @GeneratedValue
     */
    protected $id;

    /**
     * @var integer
     * @Column(type="integer")
     */
    protected $product_id;

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
     * @return integer
     */
    public function getProductId()
    {
        return $this->product_id;
    }

    /**
     * @param integer $product_id
     */
    public function setProductId($product_id)
    {
        $this->product_id = $product_id;
    }

    /**
     * @return integer
     */
    public function getCategoryId()
    {
        return $this->category_id;
    }

    /**
     * @param integer $category_id
     */
    public function setCategoryId($category_id)
    {
        $this->category_id = $category_id;
    }
}