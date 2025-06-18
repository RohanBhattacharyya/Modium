<?php 
require '../vendor/autoload.php';
require 'mod.php';

$modName = $_GET['name'] ?? "";
$modLoader = explode(",",$_GET['loader']);
$modVersion = $_GET['version'];


$curseforgeresults = json_decode(file_get_contents("curseforge.php?name=$modName&version=$modVersion"), true);
$modrinthresults = json_decode(file_get_contents("modrinth.php?name=$modName&version=$modVersion"), true);
echo $curseforgeresults;
echo $modrinthresults;
$allTheMods = [];
foreach ($curseforgeresults as $key => $value) {
    $allTheMods[] = $value;
}
foreach ($modrinthresults as $key => $value) {
    $allTheMods[] = $value;
}

echo json_encode($allTheMods, JSON_UNESCAPED_SLASHES);



?>