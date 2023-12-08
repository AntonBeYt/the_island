<?php
require 'vendor/autoload.php';

use GuzzleHttp\Client;
use Dotenv\Dotenv;
use benhall14\phpCalendar\Calendar as Calendar;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

//session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="style.css">
     <title>Document</title>
</head>

<body>
     <nav>
          <h1><?= $_ENV['HOTEL_NAME'] ?></h1>
     </nav>