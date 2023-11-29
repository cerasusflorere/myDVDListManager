<?php

//DVD クラスの読み込み
require_once '../../models/DVD.class.php"';
//Location クラスの読み込み
require_once '../../models/Location.class.php"';
//Group クラスの読み込み
require_once '../../models/Group.class.php"';
//Character クラスの読み込み
require_once '../../models/Character.class.php"';
//Other クラスの読み込み
require_once '../../models/Other.class.php"';

class AddLogic
{
    function addDetailInformation($infomations) {
        $dataDVD = new DVD();
        $dataLocations = array();
        $dataGroups = array();
        $dataCharacters = array();

        $dataDVD = $this -> setDVDInfomation($infomations);
        $dataLocations = $this -> setLocationsInfomation($infomations);
        $dataGroups = $this -> setGroupsInfomations($infomations);
        $dataCharacters = $this -> setCharactersInfomation($infomations);
        $dataOthers = $this -> setOthersInfomation($infomations);
        
        return $dataOthers;
    }

    function setDVDInfomation($infomations) {
        if($infomations -> title && $infomations -> title_kana) {
            $dataDVD = new DVD();
            $dataDVD -> setTitle($infomations -> title);
            $dataDVD -> setTitleKana($infomations -> title_kana);
            $dataDVD -> setDuration_from($infomations -> duration_from);
            $dataDVD -> setDuration_to($infomations -> duration_to);
            $dataDVD -> setImpression($infomations -> impression);
            $dataDVD -> setStory($infomations -> story);
            $dataDVD -> setAuthor($infomations -> author);
            $dataDVD -> setHistory($infomations -> history);
            $dataDVD -> setOfficial($infomations -> official);
            $dataDVD -> setSpecial($infomations -> special);
            $dataDVD -> setEoshi($infomations -> eoshi);
            $dataDVD -> setGekicine($infomations -> gekicine);
            $dataDVD -> setCategory($infomations -> category);

            return $dataDVD;
        } else {
            return null;
        }
    }

    function setLocationsInfomation($infomations) {
        if(count($infomations -> locations)) {
            $locations = $infomations -> locations;
            $dataLocations = array();

            foreach($locations as $location){
                $dataLocation = new Location();
                $dataLocation -> setPrefecture($location -> prefecture);
                $dataLocation -> setTheater($location -> theater);

                array_push($dataLocations,$dataLocation);
            }

            return $dataLocations;
        } else {
            return null;
        }
    }

    function setGroupsInfomations($infomations) {
        if(count($infomations -> groups)){
            $groups = $infomations -> groups;
            $dataGroups = array();

            foreach($groups as $group) {
                $dataGroup = new Group();
                $dataGroup -> setGroup($group);

                array_push($dataGroups, $dataGroup);
            }

            return $dataGroups;
        } else {
            return null;
        }
    }

    function setCharactersInfomation($infomations) {
        if(count($infomations -> characters)) {
            $characters = $infomations -> characters;
            $dataCharacters = array();

            foreach($characters as $character) {
                $dataCharacter = new Character();
                $dataCharacter -> setRoll($character -> roll);
                $dataCharacter -> setPlayer($character -> player);
                $dataCharacter -> setMember($character -> member);
                $dataCharacter -> setImpression($character -> impression);
                $dataCharacter -> setPhoto($character -> photo);

                array_push($dataCharacters, $dataCharacter);
            }

            return $dataCharacters;
        } else {
            return null;
        }
    }

    function setOthersInfomation($infomations) {
        if(count($infomations -> others)) {
            $others = $infomations -> others;
            $dataOthers = array();

            foreach($others as $other) {
                $dataOther = new Other();
                $dataOther -> setTitle($other -> title);
                $dataOther -> setImpression($other -> impression);

                array_push($dataOthers, $dataOther);
            }

            return $dataOthers;
        } else {
            return null;
        }
    }
}