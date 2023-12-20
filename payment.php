<?php
require __DIR__ . ('/header.php');
$db = new PDO('sqlite:booking.db');

$subtotal = 0;
$CI = strtotime($_SESSION['check-in']);
$CU = strtotime($_SESSION['check-out']) + 86400;
$days = ($CU - $CI) / 86400;

if ($_SESSION['standard'] === 'luxury') {
     $roomPrice = $_ENV['LUXURY_COST'];
}
if ($_SESSION['standard'] === 'standard') {
     $roomPrice = $_ENV['STANDARD_COST'];
}
if ($_SESSION['standard'] === 'economy') {
     $roomPrice = $_ENV['ECONOMY_COST'];
}

$subtotal = $subtotal + ($days * $roomPrice) + $_ENV['BOOKING_FEE'];
$_SESSION['subtotal'] = $subtotal;

?>
<div class="centering">
     <p>Thank you <?= $_SESSION['guest'] ?> for your reservation.</p>
     <?php if ($_SESSION['check-in'] === $_SESSION['check-out']) { ?>
          <p>You have selected our <?= $_SESSION['standard'] ?> room for <?= $_SESSION['check-in'] ?>. </p>
     <?php } else { ?>
          <p>You have selected our <?= $_SESSION['standard'] ?> room between <?= $_SESSION['check-in'] ?> and <?= $_SESSION['check-out'] ?>. </p>
     <?php } ?>
     <p>Cost: <br>
          <?= $days ?> <?php if ($days === 1) {
                              echo "day";
                         } else {
                              echo "days";
                         }
                         ?> in <?= ucfirst($_SESSION['standard']) ?> accomodation á <?= $roomPrice ?>$ = <?= $days * $roomPrice ?>$ <br>

          <?php foreach ($_SESSION['addons'] as $addon) :
               $subtotal = $subtotal + $_ENV[strtoupper($addon) . "_COST"] ?>
               1 <?= ucfirst($addon) ?> á <?= $_ENV[strtoupper($addon) . "_COST"] ?> $ <br>
          <?php endforeach ?>

          booking fee á <?= $_ENV['BOOKING_FEE'] ?>$</p>
     <p>Your subtotal comes to: <?= $subtotal ?>$.</p>
     <form method="post" action="validation.php">
          <input type="text" placeholder="payment code" name="pay-code">
          <input type="submit" name="submit">
     </form>
</div>