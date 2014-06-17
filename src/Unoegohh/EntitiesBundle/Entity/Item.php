<?php
namespace Unoegohh\EntitiesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="Unoegohh\EntitiesBundle\Repository\ItemRepository")
 * @ORM\Table(name="item")
 */
class Item
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\Column(type="string")
     */
    protected $description;

    /**
     * @ORM\Column(type="integer")
     */
    protected $price;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $sale_price;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $active;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $new;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $main_page;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $sale;

    /**
     * @ORM\OneToMany(targetEntity="Unoegohh\EntitiesBundle\Entity\ItemImage", mappedBy="item_id", cascade={"remove", "persist"})
     **/
    protected $photos;

    /**
     * @ORM\ManyToOne(targetEntity="Unoegohh\EntitiesBundle\Entity\ItemCategory", inversedBy="items")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     **/
    protected $category_id;

    function __construct()
    {
        $this->photos = new ArrayCollection();
    }

    /**
     * @param mixed $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * @return mixed
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param mixed $category_id
     */
    public function setCategoryId($category_id)
    {
        $this->category_id = $category_id;
    }

    /**
     * @return mixed
     */
    public function getCategoryId()
    {
        return $this->category_id;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $main_page
     */
    public function setMainPage($main_page)
    {
        $this->main_page = $main_page;
    }

    /**
     * @return mixed
     */
    public function getMainPage()
    {
        return $this->main_page;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $new
     */
    public function setNew($new)
    {
        $this->new = $new;
    }

    /**
     * @return mixed
     */
    public function getNew()
    {
        return $this->new;
    }

    /**
     * @param mixed $photos
     */
    public function setPhotos($photos)
    {
        $this->photos = $photos;
    }

    /**
     * @return mixed
     */
    public function getPhotos()
    {
        return $this->photos;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $sale
     */
    public function setSale($sale)
    {
        $this->sale = $sale;
    }

    /**
     * @return mixed
     */
    public function getSale()
    {
        return $this->sale;
    }

    /**
     * @param mixed $sale_price
     */
    public function setSalePrice($sale_price)
    {
        $this->sale_price = $sale_price;
    }

    /**
     * @return mixed
     */
    public function getSalePrice()
    {
        return $this->sale_price;
    }


}