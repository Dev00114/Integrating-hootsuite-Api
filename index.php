<!DOCTYPE html>
<html>
<head>
    <title>This is hootsuite testing site</title>
</head>
<body>
<?php
include_once("./autoload.php");

use HootSuite\HootsuiteManager;
use HootSuite\TableManager;

$manager = HootsuiteManager::instance();
$socials = $manager->getSocials();

var_dump($socials);

$tblMng = new TableManager();
$draft_id = $tblMng->addMedia("2020-03-29 16:25:33", $socials[0]->id, "test 2", "This is test 2", "D:/bg.jpg", 'image/jpg');

echo "You added a record in the database. draft_id : {$draft_id}";
$manager->postOne($draft_id);
echo "Your message is posted successfully.";
?>

<p>This is hootsuite testing.......</p>

</body>
</html>