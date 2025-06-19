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


foreach ($modrinthresults as $key => $value) {
    global $allTheMods;
    $allTheMods[] = $value;
}
foreach ($curseforgeresults as $key => $value) {
    global $allTheMods;
    $allTheMods[] = $value;
}

// Check for duplicates and remove
$nameCounts = [];

foreach ($allTheMods as $key => $mod) {
    $nameCounts[$mod->name][] = $key;
}


$allTheMods2 = [];
foreach ($nameCounts as $name => $keys) {
    $newMod = clone $allTheMods[$keys[0]];
    $newMod->link = [];
    foreach($keys as $key => $index){
        $newMod->link[]=$allTheMods[$index]->link;
    }
    $allTheMods2[] = $newMod;
}

echo json_encode($allTheMods2);

?>