<?php 

$modName = $_GET['name'] ?? "";
$modLoader = explode(",",$_GET['loader']);
$modVersion = $_GET['version'];

require 'mod.php';
require '../vendor/autoload.php';

use GuzzleHttp\Client;



$client = new Client();

$res = $client->request('GET', "https://api.modrinth.com/v2/search?string=$modName", [
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

echo json_encode($allTheMods, JSON_UNESCAPED_SLASHES);

?>