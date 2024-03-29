<?php

use benhall14\phpCalendar\Calendar;

require __DIR__ . ('/header.php');
require __DIR__ . ('/prizevars.php');

$calendar = new Calendar;
$calendar->useMondayStartingdate();
$db = new PDO('sqlite:booking.db');
$bookedDays = $db->prepare('SELECT DISTINCT check_in_date, check_out_date FROM booking WHERE standard = :standard');
$bookedDays->bindParam(':standard', $_POST['standard-choice']);
$bookedDays->execute();
$bookedDates = $bookedDays->fetchAll(PDO::FETCH_ASSOC);
$booked = [];
foreach ($bookedDates as $bookedDate) {
     $booked[] = [
          'start' => $bookedDate['check_in_date'],
          'end' => $bookedDate['check_out_date'],
          'mask' => true
     ];
}
if (isset($_SESSION['user'])) {
     $deleteAddons = $db->prepare('DELETE FROM booking_features WHERE booking_features.guest_id IN (SELECT id FROM booking WHERE id = :id AND payment_code IS NULL);
     ');
     $deleteAddons->bindParam(':id', $_SESSION['user']);
     $deleteAddons->execute();
     $deleteBooking = $db->prepare('DELETE FROM booking WHERE (id = :id AND payment_code IS NULL)');
     $deleteBooking->bindParam(':id', $_SESSION['user']);
     $deleteBooking->execute();
}
?>
<section>
     <div class="header-wrapper">
     </div>
</section>
<?php if (!isset($_POST['standard-choice'])) : ?>
     <section class="welcome">
          <p>Welcome to the singular <?= $_ENV['ISLAND_NAME'] ?> and &#9734;&#9734;&#9734;&#9734; hotel <?= $_ENV['HOTEL_NAME'] ?></p>
          <p>We have everything anyone could need</p>
          <p>Scroll down to see our rooms and extra features</p>
          <p>Book five or more days to recieve a 25% discount on your room</p>
     </section>
<?php endif; ?>

<section class="form-wrapper">
     <?php if (isset($_POST['standard-choice'])) {
          $calendar->addEvents($booked);
          echo $calendar->draw(date('2024-01-01'));
     }
     ?>
     <form action="index.php" method="post" id="standard-choice-form" class="standard-choice-form">
          <div class="standard-radio-wrapper">
               <input type="radio" name="standard-choice" value="luxury" id="luxury" <?php if (isset($_POST['standard-choice']) && $_POST['standard-choice'] === 'luxury') {
                                                                                          echo "checked";
                                                                                          $_SESSION['standard'] = 'luxury';
                                                                                     } ?>>
               <label for="luxury">Luxury</label>
               <input type="radio" name="standard-choice" value="standard" id="standard" <?php if (isset($_POST['standard-choice']) && $_POST['standard-choice'] === 'standard') {
                                                                                               echo "checked";
                                                                                               $_SESSION['standard'] = 'standard';
                                                                                          } ?>>
               <label for="standard">Standard</label>
               <input type="radio" name="standard-choice" value="economy" id="economy" <?php if (isset($_POST['standard-choice']) && $_POST['standard-choice'] === 'economy') {
                                                                                               echo "checked";
                                                                                               $_SESSION['standard'] = 'economy';
                                                                                          } ?>>
               <label for="economy">Economy</label>
               <input type="hidden" value="scrollPos" id="scroll-position" name="scroll-position">
          </div>
          <input type="submit" name="submit" value="Check Availability" id="availability-btn" onclick="setScroll()">
     </form>
     <?php if (isset($_POST['standard-choice'])) : ?>
          <form action="insert.php" method="post" class="insert-form">
               <label for="check-in">Select check-in date:</label>
               <input type="date" min="2024-01-01" max="2024-01-31" name="check-in" id="check-in" required>
               <label for="check-out">Select check-out date:</label>
               <input type="date" min="2024-01-01" max="2024-01-31" name="check-out" id="check-out" required>
               <input type="text" name="name" id="name" placeholder="your name" required>

               <div class="addons">
                    <div class="show-addons" id="show-addons"><span>Additional features</span> <span id="more">+</span> <span class="hidden" id="less">-</span></div>
                    <div class="addons-wrapper" id="addons-wrapper">
                         <input type="checkbox" value="karaoke" name="addons[]" id="karaoke">
                         <label for="karaoke">Karaoke</label>
                         <br>
                         <input type="checkbox" value="petanque" name="addons[]" id="petanque">
                         <label for="petanque">Pétanque</label>
                         <br>
                         <input type="checkbox" value="safari" name="addons[]" id="safari">
                         <label for="safari">Cryptid Safari</label>
                         <br>
                         <input type="checkbox" value="tour" name="addons[]" id="tour">
                         <label for="tour">Guided Tour</label>
                         <br>
                         <input type="checkbox" value="maybells" name="addons[]" id="maybells">
                         <label for="maybells">Maybells</label>
                         <br>
                         <input type="checkbox" value="novel" name="addons[]" id="novel">
                         <label for="novel">Dick Mullen Novel</label>
                         <br>
                         <input type="checkbox" value="pen" name="addons[]" id="pen">
                         <label for="pen">Kind Green Ape Pen</label>
                         <br>
                         <input type="checkbox" value="necktie" name="addons[]" id="necktie">
                         <label for="necktie">Horiffic Necktie</label>
                    </div>
               </div>
               <input type="submit" name="submit" id="submit" value="Continue to payment">

          </form>
     <?php endif; ?>

</section>
<section class="room-info">
     <div class="room-copy">
          <p>Our Luxury room offers the latest in comfort, convenience and indulgence.
               Lean back, relax and let us pamper you.
          </p>
          <p><?= getRoomPrice('luxury') ?>$/night</p>
     </div>
     <div class="img-wrapper">
          <img class="room-img" src="./assets/AI_luxury_room.jpeg" alt="luxury room">
     </div>
</section>
<section class="room-info reverse">
     <div class="img-wrapper">
          <img class="room-img" src="./assets/AI_standard_room2.jpeg" alt="standard room">
     </div>
     <div class="room-copy">
          <p>Our Standard room is for the traveller who desire comfort but came for the sights.
               Enjoy a stay without hassle or frills.</p>
          <p><?= getRoomPrice('standard') ?>$/night</p>
     </div>
</section>
<section class="room-info">
     <div class="room-copy">
          <p>For the thifty traveller without scruples we have the Economy room.
               For the adventurer who just need a safe place to sleep between outings, the Economy room is for you!
          </p>
          <p><?= getRoomPrice('economy') ?>$/night</p>
     </div>
     <div class="img-wrapper">
          <img class="room-img" src="./assets/AI_dumpster.jpeg" alt="economy room">
     </div>
</section>
<section class="features-info">
     <div class="feature">
          <div class="feature-copy">
               <p>Sing yout heart out on our Karaoke-stage!</p>
               <p><?= getFeaturePrice('karaoke') ?>$</p>
          </div>
          <img class="feature-img" src="./assets/AI_karaoke.jpeg" alt="">
     </div>
     <div class="feature">
          <div class="feature-copy">
               <p>Play some classic Pétanque</p>
               <p><?= getFeaturePrice('petanque') ?>$</p>
          </div>
          <img class="feature-img" src="./assets/AI_petanque.jpeg" alt="">
     </div>
     <div class="feature">
          <div class="feature-copy">
               <p>Go on a Cryptid safari. Will you be the first to find the elusive Col Do Ma Ma Daqua?
                    Or mabye prove the existance of the Insulindian Phasmid?
               </p>
               <p><?= getFeaturePrice('safari') ?>$</p>
          </div>
          <img class="feature-img" src="./assets/AI_cryptid.jpeg" alt="">
     </div>
     <div class="feature">
          <div class="feature-copy">
               <p>Book a tour guide for the coast. See the sights. Experience the 2mm hole in reality.</p>
               <p><?= getFeaturePrice('tour') ?>$</p>
          </div>
          <img class="feature-img" src="./assets/AI_harbor.jpeg" alt="">
     </div>
     <div class="feature">
          <div class="feature-copy">
               <p>A fresh bouquet of maybells to spread a pleasant smell in your room.</p>
               <p><?= getFeaturePrice('maybells') ?>$</p>
          </div>
          <img class="feature-img" src="./assets/AI_maybells.jpeg" alt="">
     </div>
     <div class="feature">
          <div class="feature-copy">
               <p>A thrilling crime-novel to enjoy and remember your stay by.</p>
               <p><?= getFeaturePrice('novel') ?>$</p>
          </div>
          <img class="feature-img" src="./assets/AI_dick_mullen.jpeg" alt="">
     </div>
     <div class="feature">
          <div class="feature-copy">
               <p>A commemorative pen, featuring local legendary cryptid the Kind Green Ape.</p>
               <p><?= getFeaturePrice('pen') ?>$</p>
          </div>
          <img class="feature-img" src="./assets/AI_green_ape.jpeg" alt="">
     </div>
     <div class="feature">
          <div class="feature-copy">
               <p>A truly horrific necktie to make your friends envious.</p>
               <p><?= getFeaturePrice('novel') ?>$</p>
          </div>
          <img class="feature-img" src="./assets/AI_necktie.jpeg" alt="">
     </div>
</section>
<?php require __DIR__ . ('/footer.php'); ?>