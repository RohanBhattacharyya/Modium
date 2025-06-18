<?php 

require '../vendor/autoload.php';
require 'mod.php';

use GuzzleHttp\Client;




$modName = $_GET['name'] ?? "";
$modLoader = explode(",",$_GET['loader']);
$modVersion = $_GET['version'];



$client = new Client([
    'base_uri' => 'https://www.curseforge.com',
    'headers' => [
        'User-Agent' => 'Mozilla/5.0 (X11; Linux x86_64; rv:139.0) Gecko/20100101 Firefox/139.0',
        'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
        'Accept-Language' => 'en-US,en;q=0.5',
        'Accept-Encoding' => 'gzip, deflate, br, zstd',
        'Referer' => 'https://www.curseforge.com/minecraft',
        'Sec-GPC' => '1',
        'Connection' => 'keep-alive',
        'Upgrade-Insecure-Requests' => '1',
        'Sec-Fetch-Dest' => 'document',
        'Sec-Fetch-Mode' => 'navigate',
        'Sec-Fetch-Site' => 'same-origin',
        'Sec-Fetch-User' => '?1',
        'DNT' => '1',
        'Priority' => 'u=0, i',
    ]
]);

$modLoaders = array(
    "forge" => 1,
    "fabric" => 4,
    "neoforge" => 6,
    "quilt" => 5
);

$query = [
    'page' => '1',
    'pageSize' => '20',
    'sortBy' => 'total downloads',
    'search' => $modName,
];

if (isset($modLoader) && is_array($modLoader) && count($modLoader) > 0) {
    $returnString = '';

    foreach ($modLoader as $loader) {
        if (isset($modLoaders[$loader])) {
            $returnString .= $modLoaders[$loader] . ',';
        }
    }

    $gameVersionTypeId = rtrim($returnString, ',');

    if ($gameVersionTypeId !== '') {
        $query['gameVersionTypeId'] = $gameVersionTypeId;
    }
}

$response = $client->request('GET', '/minecraft/search', [
    'query' => $query
]);

$doc = Dom\HTMLDocument::createFromString($response->getBody());
$mods = $doc->querySelectorAll('.project-card');
$allTheMods = array();

foreach($mods as $key => $mod){
    global $allTheMods;
    $workingMod = new Mod();
    $workingMod->name = $mod->querySelector('.name')->querySelector('.ellipsis')->innerHTML;
    $workingMod->description = $mod->querySelector('.description')->innerHTML;
    $workingMod->art = $mod->querySelector('.art')->querySelector('img')->getAttribute('src');
    $workingMod->link = "https://www.curseforge.com" . $mod->querySelector('.name')->getAttribute('href');
    $allTheMods[] = $workingMod;
}


echo json_encode($allTheMods, JSON_UNESCAPED_SLASHES);