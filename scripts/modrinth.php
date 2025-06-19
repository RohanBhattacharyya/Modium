<?php 

$modName = $_GET['name'] ?? "";
$modLoader = explode(",",$_GET['loader']);
$modVersion = $_GET['version'];

require_once 'mod.php';
require_once '../vendor/autoload.php';

use GuzzleHttp\Client;


function modrinth($modName, $modLoader, $modVersion){


$client = new Client();

$loaderString = "[";

foreach ($modLoader as $key => $loader) {
    if ($loader === null || $loader === ""){
        continue;
    }
    $loaderString .= "\"categories: $loader\",";
}

$loaderString = rtrim($loaderString, ",");
$loaderString .= "]";

$uri = "https://api.modrinth.com/v2/search?query=$modName&facets=[[\"project_type:mod\"]" . (($loaderString === "[]") ? "" : ',' . $loaderString) . "]&index=downloads";
$res = $client->request('GET', $uri, [
    'auth' => ['user', 'pass']
]);

$mods = json_decode($res->getBody());

$allTheMods = [];

foreach ($mods->hits as $key => $mod) {
    $workingMod = new Mod();
    $workingMod->name = $mod->title;
    $workingMod->art = $mod->icon_url;
    $workingMod->description = $mod->description;
    $workingMod->link = "https://modrinth.com/mod/" . $mod->slug;
    $workingMod->downloads = (int)$mod->downloads;
    $allTheMods[] = $workingMod;
}

// echo var_dump($allTheMods);
return $allTheMods;

}

// modrinth($modName, $modLoader, $modVersion);