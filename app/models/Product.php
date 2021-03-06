<?php

namespace app\models;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use \Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * Class Product
 * @Entity @Table(name="products")
 */
class Product implements \JsonSerializable
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
     * @ManyToMany(targetEntity="Category", cascade={"persist"})
     * @JoinTable(name="product_category",
     *      joinColumns={@JoinColumn(name="product_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="category_id", referencedColumnName="id")}
     *      )
     *
     * @var Category[]
     **/
    protected $categories;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
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

    public function addCategory(Category $category)
    {
        $category->addProduct($this);

        $this->categories->add($category);
    }

    /**
     * @param Category $category
     */
    public function removeCategory(Category $category)
    {
        $this->categories->removeElement($category);
    }

    /**
     * @return Category[]|ArrayCollection
     */
    public function getCategories()
    {
        return $this->categories;
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
                               'id'         => $this->id,
                               'title'      => $this->title,
                               'categories' => $this->getCategories()->toArray(),
                           ]);
    }
}