<?php
class Rent
{
    private $DVDId;
    private $id;
    private $rent;
    private $flag;

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

    function getRent() {
        return $this -> rent;
    }
    function setRent($data) {
        $this -> rent = $data;
    }

    function getFlag() {
        return $this -> flag;
    }
    function setFlag($data) {
        if($data) {
            $this -> flag = true;
        } else {
            $this -> flag = false;
        }
    }
}