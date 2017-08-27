<?php

namespace app\models;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints\NotBlank;


/**
 * Class Product
 * @Entity @Table(name="categories")
 */
class Category implements \JsonSerializable
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
     * @var ArrayCollection|Product[]
     */
    protected $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

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
     * @param Product $product
     */
    public function addProduct(Product $product)
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
        }
    }

    /**
     * @return Product[]|ArrayCollection
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param ClassMetadata $metadata
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('title', new NotBlank());
        $metadata->addPropertyConstraint('title', new NotNull());
        $metadata->addPropertyConstraint('title', new Length(255));

        $metadata->addPropertyConstraint('price', new NotBlank());
        $metadata->addPropertyConstraint('price', new NotNull());
        $metadata->addPropertyConstraint('price', new Length(255));
    }

    /**
     * @return string
     */
    public function jsonSerialize()
    {
        return json_encode([
                               'id'    => $this->id,
                               'title' => $this->title,
                           ]);
    }
}