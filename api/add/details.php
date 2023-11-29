<?php
//DVD クラスの読み込み
require_once "../../models/DVD.class.php";
//Location クラスの読み込み
require_once '../../models/Location.class.php"';
//Group クラスの読み込み
require_once "../../models/Group.class.php";
//Character クラスの読み込み
require_once "../../models/Character.class.php";
//Other クラスの読み込み
require_once "../../models/Other.class.php";

// AddLogic の読み込み
require_once "../../logic/AddLogic.php";
//DVD オブジェクトを生成して変数に代入
$informationSet = new DVD();
// logic
$addLogic = new AddLogic();

$get_data = filter_input(INPUT_POST,"data");
$data = json_decode($get_data);
header("Content-type: application/json;charset=UTF-8");

$informationSet = $addLogic -> addDetailInformation($data);
var_dump($informationSet);
