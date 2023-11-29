<?php
class Group
{
    private $DVDId;
    private $id;
    private $group;

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

    function getGroup() {
        return $this -> group;
    }
    function setGroup($data) {
        $this -> group = $data;
    }
}