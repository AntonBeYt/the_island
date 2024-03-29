<?php
require __DIR__ . ('/header.php');
$db = new PDO('sqlite:booking.db');

$subtotal = 0;
$CI = strtotime($_SESSION['check-in']);
$CU = strtotime($_SESSION['check-out']) + 86400;
$days = ($CU - $CI) / 86400;
if ($days > 5) {
     $discount = true;
} else {
     $discount = false;
}

$standardCost = $db->prepare('SELECT price FROM standards WHERE standard = :standard');
$standardCost->bindParam(':standard', $_SESSION['standard']);
$standardCost->execute();
$roomPrice = $standardCost->fetch(PDO::FETCH_ASSOC)['price'];
$roomCost = $days * $roomPrice;
$discountRoomCost = (int) ceil(($days * $roomPrice) * 0.75);


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
                         ?> in <?= ucfirst($_SESSION['standard']) ?> accomodation á <?= $roomPrice ?>$ =
          <?php if ($days >= 5) {
               $subtotal = $subtotal + $discountRoomCost + $_ENV['BOOKING_FEE'];
               echo "<s>" . $roomCost . "$  </s>" . $discountRoomCost;
          } else {
               $subtotal = $subtotal + $roomCost + $_ENV['BOOKING_FEE'];
               echo $roomCost;
          } ?>$ <br>
          <?php foreach ($_SESSION['addons'] as $addon) :
               $addonCost = $db->prepare('SELECT price FROM features WHERE feature_name = :feature_name');
               $addonCost->bindParam(':feature_name', $addon);
               $addonCost->execute();
               $addonPrice = $addonCost->fetch()['price'];
               $subtotal = $subtotal + $addonPrice ?>
               1 <?= ucfirst($addon) ?> á <?= $addonPrice ?> $ <br>
          <?php endforeach; ?>
          booking fee á <?= $_ENV['BOOKING_FEE'] ?>$</p>
     <p>Your subtotal comes to: <?= $subtotal ?>$.</p>
     <form method="post" action="validation.php">
          <input type="text" placeholder="payment code" name="pay-code">
          <input type="submit" name="submit">
     </form>
</div>
<?php $_SESSION['subtotal'] = $subtotal;
require __DIR__ . ('/footer.php');
