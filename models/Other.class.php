<?php
class Other
{
    private $DVDId;
    private $id;
    private $title;
    private $impression;

    function getDVDId() {
        return $this -> DVDId;
    }
    function setDVDId($data) {
        $this -> DVDId = $data;
    }
    
    function getId() {
        return $this -> id;
    }
    function setId($data) {
        $this -> id = $data;
    }

    function getTitle() {
        return $this -> title;
    }
    function setTitle($data) {
        $this -> title = $data;
    }

    function getImpression() {
        return $this -> impression;
    }
    function setImpression($data) {
        $this -> impression = $data;
    }
}