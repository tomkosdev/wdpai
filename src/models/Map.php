<?php

class Map {
    private $id;
    private $title;
    private $date;
    private $description;
    private $image;
    private $likes;
    private $uploader;

    public function __construct($title, $date, $description, $image, $likes = null, $id = null, $uploader=null)
    {
        $this->id = $id;
        $this->title = $title;
        $this->likes = $likes;
        $this->description = $description;
        $this->image = $image;
        $this->uploader = $uploader;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function getLiked()
    {
        return $this->likes;
    } 
    
    public function setlikes($likes)
    {
        $this->likes = $likes;
    } 

    public function getUploader()
    {
        return $this->uploader;
    } 
    
    public function setUploader($uploader)
    {
        $this->uploader = $uploader;
    } 


}