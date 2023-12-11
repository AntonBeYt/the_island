<?php

use benhall14\phpCalendar\Calendar;

require __DIR__ . ('/header.php');

$calendar = new Calendar;
$calendar->useMondayStartingdate();
$calendar->addEvent(
     '2024-01-01',
     '2024-01-01',
     '',
     true,
     ['myclass', 'abc']
);
echo $calendar->draw(date('2024-01-01'));

?>
<form action="insert.php" method="post">
     <input type="date" min="2024-01-01" max="2024-01-31" name="check-in">
     <input type="date" min="2024-01-01" max="2024-01-31" name="check-out">
     <input type="text" name="name" id="name" placeholder="your name">
     <div class="standard-radio-wrapper">
          <input type="radio" name="standard-choice" value="luxury" id="luxury">
          <label for="luxury">Luxury</label>
          <input type="radio" name="standard-choice" value="standard" id="standard">
          <label for="standard">Standard</label>
          <input type="radio" name="standard-choice" value="economy" id="economy">
          <label for="economy">Economy</label>
     </div>
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
<?php if (isset($_POST['check-in'])) {
     var_dump($_POST);
}


// $statement = $db->query('SELECT * FROM features');
// $features = $statement->fetchAll(PDO::FETCH_ASSOC);
// echo "<pre>";
// var_dump($features);
// $cost = 0;
// foreach ($features as $feature) {
//      $cost = $cost + $feature['price'];
// }
// echo $cost;
?>

<?php require __DIR__ . ('/footer.php'); ?>