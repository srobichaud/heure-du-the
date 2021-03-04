<?php
require_once("vendor/autoload.php");

$endpoint = file_get_contents('.env');
$json = file_get_contents('state.json');

$json = json_decode($json);
$teaObject = null;

if($json->value == "init"){
    $teaObject = ['title' => "Il faut préparer l'eau", 'text' => 'Il faut aller partir la bouilloire svp.'];
    $json->value = "ready";
}
else{
    $teaObject = ['title' => "C'est l'heure du thé", 'text' => "Prend un ptit break, l'eau est prête."];
    $json->value = "init";
}

$connector = new \Sebbmyr\Teams\TeamsConnector($endpoint);
// create card
$card  = new \Sebbmyr\Teams\Cards\SimpleCard($teaObject);
// send card via connector
$connector->send($card);

$fp = fopen("state.json", "w");
fwrite($fp, json_encode($json));
fclose($fp);