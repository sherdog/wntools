<?php


$level = new StdClass;

$level->objectives = array();

$words = array();

$wordObjectives = array(3 => 5);
$words[] = $wordObjectives;
$wordObjectives = array(4 => 1);
$words[] = $wordObjectives;
$level->objectives["words"] = $words;

$tileObjectives[] = array("-" => 10);
$tileObjectives[] = array("E" => 5);

$level->objectives["tiles"] = $tileObjectives;


$bonusWordArray = array("Whopper", "Steak", "Cunt");

$level->objectives['bonus_words'] = $bonusWordArray;

$bricks = array();

$bricks[] = array("default"=>10);
$bricks[] = array('chocolate' => 20);

$level->objectives['bicks'] = $bricks;
$objectives['level'] = $level;
echo json_encode($objectives);