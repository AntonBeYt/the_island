<?php

declare(strict_types=1);



function getRoomPrice(string $standard): int
{
     $db = new PDO('sqlite:booking.db');
     $standardsPrices = $db->prepare('SELECT price, standard FROM standards');
     $standardsPrices->execute();
     $roomPrices = $standardsPrices->fetchAll(PDO::FETCH_ASSOC);
     foreach ($roomPrices as $item) {
          if ($item['standard'] === $standard) {
               return $item['price'];
          }
     }
}


function getFeaturePrice(string $feature): int
{
     $db = new PDO('sqlite:booking.db');
     $featuresPrices = $db->prepare('SELECT price, feature_name FROM features');
     $featuresPrices->execute();
     $featuresPrices = $featuresPrices->fetchAll(PDO::FETCH_ASSOC);
     foreach ($featuresPrices as $item) {
          if ($item['feature_name'] === $feature) {
               return $item['price'];
          }
     }
}
