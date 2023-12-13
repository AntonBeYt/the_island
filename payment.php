<?php
require __DIR__ . ('/header.php');
$db = new PDO('sqlite:booking.db');

// echo $_SESSION['user'];
// var_dump($_SESSION);
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
if (isset($_SESSION['snickers'])) {
     $subtotal = $subtotal + $_ENV['SNICKERS_COST'];
}
if (isset($_SESSION['twix'])) {
     $subtotal = $subtotal + $_ENV['TWIX_COST'];
}
if (isset($_SESSION['bounty'])) {
     $subtotal = $subtotal + $_ENV['BOUNTY_COST'];
}
$_SESSION['subtotal'] = $subtotal;

?>

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
     <?php if (isset($_SESSION['snickers'])) : ?>
          1 <?= $_SESSION['snickers'] ?> á <?= $_ENV['SNICKERS_COST'] ?>$ <br>
     <?php endif ?>
     <?php if (isset($_SESSION['twix'])) : ?>
          1 <?= $_SESSION['twix'] ?> á <?= $_ENV['TWIX_COST'] ?>$ <br>
     <?php endif ?>
     <?php if (isset($_SESSION['bounty'])) : ?>
          1 <?= $_SESSION['bounty'] ?> á <?= $_ENV['BOUNTY_COST'] ?>$ <br>
     <?php endif ?>
     booking fee á <?= $_ENV['BOOKING_FEE'] ?>$</p>
<p>Your subtotal comes to: <?= $subtotal ?>$.</p>
<form method="post" action="validation.php">
     <input type="text" placeholder="payment code" name="pay-code">
     <input type="submit" name="submit">
</form>