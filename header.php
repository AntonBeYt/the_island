<?php
require 'vendor/autoload.php';

use GuzzleHttp\Client;
use Dotenv\Dotenv;
use benhall14\phpCalendar\Calendar as Calendar;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="style.css">
     <link rel="preconnect" href="https://fonts.googleapis.com">
     <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
     <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
     <title>Document</title>
</head>

<body onload="restoreScrollPos()">
     <nav>
          <div class="nav-wrapper">
               <img class="nav-background" src="./assets/backdrop_SVG.svg" alt="">
               <h1 class="hotel-name"><?= $_ENV['HOTEL_NAME'] ?></h1>
          </div>
     </nav>