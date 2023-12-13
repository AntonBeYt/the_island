<?php
require __DIR__ . ('/header.php');
$db = new PDO('sqlite:booking.db');



$newGuestQuery = 'INSERT INTO booking (guest_name, standard, check_in_date, check_out_date, addons) VALUES (:guest_name, :standard, :check_in_date, :check_out_date, :addons)';

$guest_name = trim($_POST['name']);
$guest_name = htmlspecialchars($guest_name, ENT_QUOTES);
$standard = $_SESSION['standard'];
$CIdate = $_POST['check-in'];
$CUdate = $_POST['check-out'];

if (isset($_POST['snickers']) || isset($_POST['twix']) || isset($_POST['bounty'])) {
     $addons = true;
     $_SESSION['addons'] = true;
} else {
     $addons = false;
     $_SESSION['addons'] = false;
}
$_SESSION['guest'] = $guest_name;
$_SESSION['standard'] = $standard;
$_SESSION['check-in'] = $CIdate;
$_SESSION['check-out'] = $CUdate;

//checks if dates are availible
$db = new PDO('sqlite:booking.db');
$bookedDays = $db->prepare('SELECT DISTINCT check_in_date, check_out_date FROM booking WHERE standard = :standard');
$bookedDays->bindParam(':standard', $standard);
$bookedDays->execute();
$bookedDates = $bookedDays->fetchAll(PDO::FETCH_ASSOC);
$clash = false;
foreach ($bookedDates as $date) {
     if (
          strtotime($date['check_out_date']) >= strtotime($_SESSION['check-in']) &&
          strtotime($date['check_in_date']) <= strtotime($_SESSION['check-out'])
     ) {
          $clash = true;
     }
}


if ($clash === false) {
     //inserts everything exept for payment into database
     $newGuestStatement = $db->prepare($newGuestQuery);
     $newGuestStatement->bindParam(':guest_name', $guest_name, PDO::PARAM_STR);
     $newGuestStatement->bindParam(':standard', $standard, PDO::PARAM_STR);
     $newGuestStatement->bindParam(':check_in_date', $CIdate, PDO::PARAM_STR);
     $newGuestStatement->bindParam(':check_out_date', $CUdate, PDO::PARAM_STR);
     $newGuestStatement->bindParam(':addons', $addons, PDO::PARAM_BOOL);

     $newGuestStatement->execute();

     $last_id = $db->lastInsertId();
     $_SESSION['user'] = $last_id;
     if (isset($_POST['snickers'])) {
          $_SESSION['snickers'] = "Snickers";
          $statement = $db->prepare('INSERT INTO booking_features (guest_id, feature_id) VALUES (:guest_id, 1)');
          $statement->bindParam(':guest_id', $last_id);
          $statement->execute();
     }
     if (isset($_POST['twix'])) {
          $_SESSION['twix'] = "Twix";
          $statement = $db->prepare('INSERT INTO booking_features (guest_id, feature_id) VALUES (:guest_id, 2)');
          $statement->bindParam(':guest_id', $last_id);
          $statement->execute();
     }
     if (isset($_POST['bounty'])) {
          $_SESSION['bounty'] = "Bounty";
          $statement = $db->prepare('INSERT INTO booking_features (guest_id, feature_id) VALUES (:guest_id, 3)');
          $statement->bindParam(':guest_id', $last_id);
          $statement->execute();
     }
     header("Location: payment.php");
} else {
     echo "problems";
     $_SESSION['error'] = "one or more of your chosen dates were unavailible, please try again";
     header("Location: index.php");
}
