<?php
class Character {
    private $DVDId;
    private $groupId;
    private $id;
    private $roll;
    private $character;
    private $member;
    private $impression;
    private $photo;
    private $photoPass;

    function getDVDId() {
        return $this -> DVDId;
    }
    function setDVDId($data) {
        $this -> DVDId = $data;
    }

    function getGroupId() {
        return $this -> groupId;
    }
    function setGroupId($data) {
        $this -> groupId = $data;
    }

    function getId() {
        return $this -> id;
    }
    function setId($data) {
        $this -> id = $data;
    }
    
    function getRoll() {
        return $this -> roll;
    }
    function setRoll($data) {
        $this -> roll = $data ;
    }

    function getPlayer() {
        return $this -> character;
    }
    function setPlayer($data) {
        $this -> character = $data;
    }

    function getMember() {
        return $this -> member;
    }
    function setMember($data) {
        if($data) {
            $this -> member = true;
        } else {
            $this -> member = false;
        }
    }

    function getImpression() {
        return $this -> impression;
    }
    function setImpression($data) {
        $this -> impression = $data ?? null;
    }

    function getPhoto() {
        return $this -> photo;
    }
    function setPhoto($data) {
        $this -> photo = $data ?? null;
    }

    function getPhotoPass() {
        return $this -> photoPass;
    }
    function setPhotoPass($data) {
        $this -> photoPass = $data ?? null;
    }
}