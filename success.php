<?php
require __DIR__ . ('/header.php');

$succ = new stdClass;
$succ->island = $_ENV['ISLAND_NAME'];
$succ->hotel = $_ENV['HOTEL_NAME'];
$succ->arrival_date = $_SESSION['check-in'];
$succ->departure_date = $_SESSION['check-out'];
$succ->total_cost = $_SESSION['subtotal'];
$succ->stars = $_ENV['STARS'];
$features = [];
foreach ($_SESSION['addons'] as $addon) {
     $envKey = strtoupper($addon) . "_COST";
     $unit = [
          'name' => $addon,
          'price' => $_ENV[$envKey]
     ];
     array_push($features, $unit);
}
if (count($features) > 0) {
     $succ->features = $features;
} else {
     $succ->features = "no additional features selected";
}
$additionalInfo = [
     'greeting' => "Thank you for choosing " . $_ENV['HOTEL_NAME'] . "!",
     'welcome_video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ'
];
$succ->additional_info = $additionalInfo;

$json = json_encode($succ, JSON_PRETTY_PRINT); ?>
<section class="centering">
     <div>
          <h3>Thank you for booking!</h3>
          <!-- <?= $succ->additional_info['welcome_video_url'] ?> -->
          <button id="show-confirmation">Show json-confirmation</button>
     </div>
     <div class="json-wrapper hidden" id="json-wrapper">
          <pre>
          <?= $json ?>
     </div>
</section>



<?php require __DIR__ . ('/footer.php');
