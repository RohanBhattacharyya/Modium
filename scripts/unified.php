<?php 
require_once '../vendor/autoload.php';
require_once 'mod.php';
require_once 'curseforge.php';
require_once 'modrinth.php';

$modName = $_GET['name'] ?? "";
$modLoader = explode(",",$_GET['loader']);
$modVersion = $_GET['version'];


$curseforgeresults = curseforge($modName, $modLoader, $modVersion);
$modrinthresults = modrinth($modName, $modLoader, $modVersion);


$allTheMods = [];

foreach ($curseforgeresults as $key => $value) {
    global $allTheMods;
    $allTheMods[] = $value;
}
foreach ($modrinthresults as $key => $value) {
    global $allTheMods;
    $allTheMods[] = $value;
}

echo json_encode($allTheMods);

?>