<?php

use benhall14\phpCalendar\Calendar;

require __DIR__ . ('/header.php');

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


if (isset($_SESSION['error'])) : ?>
     <script>
          alert("<?= $_SESSION['error'] ?>")
     </script>
<?php unset($_SESSION['error']);
endif; ?>
<section>
     <div class="header-wrapper">
          <img class="header-img" src="./assets/skyline.jpg" alt="">
     </div>
</section>

<section class="form-wrapper">
     <?php if (isset($_POST['standard-choice'])) {
          $calendar->addEvents($booked);
          echo $calendar->draw(date('2024-01-01'));
     } ?>
     <form action="index.php" method="post">
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
               <input type="submit" name="submit" value="Check Availability">
          </div>
     </form>
     <?php if (isset($_POST['standard-choice'])) : ?>
          <form action="insert.php" method="post">
               <label for="check-in">Select check-in date:</label>
               <input type="date" min="2024-01-01" max="2024-01-31" name="check-in" id="check-in" required>
               <label for="check-out">Select check-out date:</label>
               <input type="date" min="2024-01-01" max="2024-01-31" name="check-out" id="check-out" required>
               <input type="text" name="name" id="name" placeholder="your name" required>

               <div class="addons-wrapper">
                    <input type="checkbox" value="snickers" name="snickers" id="snickers">
                    <label for="snickers">snickers</label>
                    <input type="checkbox" value="twix" name="twix" id="twix">
                    <label for="twix">twix</label>
                    <input type="checkbox" value="bounty" name="bounty" id="bounty">
                    <label for="bounty">bounty</label>
               </div>
               <input type="submit" name="submit" id="submit">

          </form>
     <?php endif; ?>

</section>
<section class="room-info">
     <p>our luxury room offers stuff</p>
     <div class="img-wrapper">
          <img class="room-img" src="./assets/AI_luxury_room.jpeg" alt="">
     </div>
</section>
<section class="room-info">
     <div class="img-wrapper">
          <img class="room-img" src="./assets/AI_standard_room2.jpeg" alt="">
     </div>
     <p>out standard room offers stuff</p>
</section>
<section class="room-info">
     <p>our economy room offers stuff</p>
     <div class="img-wrapper">
          <img class="room-img" src="./assets/AI_dumpster.jpeg" alt="">
     </div>
</section>
<?php require __DIR__ . ('/footer.php'); ?>