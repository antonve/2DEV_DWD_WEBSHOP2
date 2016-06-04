<?php

// Product.php -
// By Anton Van Eechaute

namespace Devine\Shop\Model;

class Product
{
    /**
     * @var int  
     */
    private $id;

    /**
     * @var string  
     */
    private $title;

    /**
     * @var string  
     */
    private $description;

    /**
     * @var string  
     */
    private $thumb;

    /**
     * @var integer
     */
    private $price;

    /**
     * @var boolean  
     */
    private $hot;

    /**
     * @var string  
     */
    private $type;

    /**
     * @var string  
     */
    private $category;

    /**
     * Initializes a product object
     * @param integer $id
     * @param string $title
     * @param string $description
     * @param string $thumb
     * @param integer $price
     * @param boolean $hot
     * @param string $type
     * @param string $category  
     */
    public function  __construct($id, $title, $description, $thumb, $price, $hot, $type, $category)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->thumb = $thumb;
        $this->price = $price;
        $this->hot = $hot;
        $this->type = $type;
        $this->category = $category;
    }

    /**
     * @return integer  
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param integer $id  
     */
    public function setId($id)
    {
        $this->id = $id;
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
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description  
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string  
     */
    public function getThumb()
    {
        return $this->thumb;
    }

    /**
     * @param string $thumb  
     */
    public function setThumb($thumb)
    {
        $this->thumb = $thumb;
    }

    /**
     * Returns the price in euro
     * @return float
     */
    public function getPrice()
    {
        return $this->price / 100;
    }

    /**
     * @param integer $price  
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return boolean  
     */
    public function getHot()
    {
        return $this->hot;
    }

    /**
     * @param boolean $hot  
     */
    public function setHot($hot)
    {
        $this->hot = $hot;
    }

    /**
     * @return string  
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type  
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string  
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param string $category  
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }
}
