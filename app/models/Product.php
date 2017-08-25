<?php

namespace app\models;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use \Symfony\Component\Validator\Mapping\ClassMetadata;

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
     * @ManyToOne(targetEntity="ProductCategory")
     * @var ProductCategory
     **/
    protected $category = null;

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

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
//        $metadata->addPropertyConstraint('title', new NotBlank());
//        $metadata->addPropertyConstraint('title', new NotNull());
//        $metadata->addPropertyConstraint('title', new Length(255));
//
//        $metadata->addPropertyConstraint('price', new NotBlank());
//        $metadata->addPropertyConstraint('price', new NotNull());
//        $metadata->addPropertyConstraint('price', new Length(255));
//
//        $metadata->addPropertyConstraint('category_id', new NotBlank());
//        $metadata->addPropertyConstraint('category_id', new NotNull());
//        $metadata->addPropertyConstraint('category_id', new Length(255));

    }
}