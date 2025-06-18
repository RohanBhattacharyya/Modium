<?php 

$modName = $_GET['name'] ?? "";
$modLoader = explode(",",$_GET['loader']);
$modVersion = $_GET['version'];

require_once 'mod.php';
require_once '../vendor/autoload.php';

use GuzzleHttp\Client;


function modrinth($modName, $modLoader, $modVersion){


$client = new Client();

$res = $client->request('GET', "https://api.modrinth.com/v2/search?query=$modName&facets=[[\"project_type:mod\"]]&index=downloads", [
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
    $allTheMods[] = $workingMod;
}

return $allTheMods;

}

// modrinth($modName, $modLoader, $modVersion);