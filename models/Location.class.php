<?php
class Location
{
    private $DVDId;
    private $id;
    private $prefecture;
    private $theater;

    function getDVDId() {
        return $this -> DVDId;
    }
    function setDVDId($data) {
        $this -> DVDId;
    }

    function setId() {
        return $this -> id;
    }
    function getId($data) {
        $this -> id = $data;
    }

    function getPrefecture() {
        return $this -> prefecture;
    }
    function setPrefecture($data) {
        $this -> prefecture = $data;
    }

    function getTheater() {
        return $this -> theater;
    }
    function setTheater($data) {
        $this -> theater = $data;
    }
}