<?php

declare(strict_types=1);

$db = new PDO('sqlite:booking.db');


$standardsPrices = $db->prepare('SELECT price, standard FROM standards');
$standardsPrices->execute();
$roomPrices = $standardsPrices->fetchAll(PDO::FETCH_ASSOC);


function getRoomPrice(array $roomPrices, string $standard): int
{
     foreach ($roomPrices as $item) {
          if ($item['standard'] === $standard) {
               return $item['price'];
          }
     }
}

$featuresPrices = $db->prepare('SELECT price, feature_name FROM features');
$featuresPrices->execute();
$featuresPrices = $featuresPrices->fetchAll(PDO::FETCH_ASSOC);

function getFeaturePrice(array $featuresPrices, string $feature): int
{
     foreach ($featuresPrices as $item) {
          if ($item['feature_name'] === $feature) {
               return $item['price'];
          }
     }
}
