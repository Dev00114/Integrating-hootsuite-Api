<?php
namespace HootsuiteTest;

include_once("autoload.php");

use HootSuite\TableManager;
$tblMng = new TableManager();
$data = $_POST;
switch $data['type']
{
    case "com.hootsuite.messages.event.v1":
        $messageid = $data['data']['message']['id'];
        $state = $data['data']['state'];
        $tblMng->setState($messageid, $state);
        break;
    default:
        break;
}
