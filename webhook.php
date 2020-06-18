<?php
namespace HootsuiteTest;

include_once("./autoload.php");

use HootSuite\HootsuiteManager;

$code = "";
$scope = "";

if(isset($_GET['code']))
    $code = $_GET['code'];

if(isset($_GET['scope']))
    $scope = $_GET['scope'];

$myHootSuite = HootsuiteManager::instance();
$result = $myHootSuite->generateToken($code, $scope);
