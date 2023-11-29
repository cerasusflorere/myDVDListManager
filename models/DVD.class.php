<?php
class DVD
{
    private $id;
    private $title;
    private $title_kana;
    private $duration_from;
    private $duration_to;
    private $impression;
    private $story;
    private $author;
    private $history;
    private $official;
    private $special;
    private $eoshi;
    private $gekicine;
    private $category;
    private $rentFlag;

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

    function getTitleKana() {
        return $this -> title_kana;
    }
    function setTitleKana($data) {
        $this -> title_kana = $data;
    }

    function getDuration_from() {
        return $this -> duration_from;
    }
    function setDuration_from($data) {
        $this -> duration_from = $data ?? null;
    }

    function getDuration_to() {
        return $this -> duration_to;
    }
    function setDuration_to($data) {
        $this -> duration_to = $data ?? null;
    }

    function getImpression() {
        return $this -> impression;
    }
    function setImpression($data) {
        $this -> impression = $data ?? null;
    }

    function getStory() {
        return $this -> story;
    }
    function setStory($data) {
        $this -> story = $data ?? null;
    }

    function getAuthor () {
        return $this -> author;
    }
    function setAuthor($data) {
        $this -> author = $data ?? null;
    }

    function getHistory() {
        return $this -> history;
    }
    function setHistory($data) {
        $this -> history = $data ?? null;
    }

    function getOfficial() {
        return $this -> official;
    }
    function setOfficial($data) {
        if($data) {
            $this -> official = true;
        } else {
            $this -> official = false;
        }
    }

    function getSpecial() {
        return $this -> special;
    }
    function setSpecial($data) {
        if($data) {
            $this -> special = true;
        } else {
            $this -> special = false;
        }
    }

    function getEoshi() {
        return $this -> eoshi;
    }
    function setEoshi($data) {
        $this -> eoshi = $data ?? null;
    }

    function getGekicine() {
        return $this -> gekicine;
    }
    function setGekicine($data) {
        $this -> gekicine = $data ?? null;
    }

    function getCategory() {
        return $this -> category;
    }
    function setCategory($data) {
        if(preg_match("/^[0-9]+$/",$data)){
            if(is_int($data)) {
                if($data < 5){
                    $this -> category = $data;
                } else {
                    $this -> category = null;
                }
            } else {
                if($data === '1' || $data === '2' || $data === '3' || $data === '4') {
                    $this -> category = (int) $data;
                } else {
                    $this -> category = null;
                }
            }
        } else {
            $this -> category = null;
        }        
    }

    function getRentFlag() {
        return $this -> rentFlag;
    }
    function setRentFlag($data) {
        $this -> rentFlag = $data ?? null;
    }
}
