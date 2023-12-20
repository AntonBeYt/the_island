<?php
require __DIR__ . ('/header.php');
$db = new PDO('sqlite:booking.db');

if (isset($_POST['secret'])) {
     $password = trim($_POST['secret']);
     $password = htmlspecialchars($password, ENT_QUOTES);
     if ($password === $_ENV['API_KEY']) {
          $_SESSION['admin'] = true;
          unset($_POST['secret']);
     } else { ?>
          <script>
               alert("Nice try buster!")
          </script>
<?php unset($_POST['secret']);
     }
}
?>



<div class="centering">
     <?php if (!isset($_SESSION['admin'])) : ?>
          <form action="admin.php" method="post" class="adminform">
               <label for="secret">Enter secret code:</label>
               <input type="password" name="secret" id="secret" placeholder="**********">
               <input type="submit">
          </form>
     <?php endif;
     if (isset($_SESSION['admin'])) :
     ?>
          <h1>Update prices:</h1>
          <p>Please refresh page to see updated prices</p>
          <p>No decimals accepted</p>
          <form action="admin.php" method="post" class="update-form">
               <?php
               $rooms = $db->prepare('SELECT standard, price FROM standards');
               $rooms->execute();
               $rooms = $rooms->fetchAll(PDO::FETCH_ASSOC); ?>
               <h3>Rooms:</h3>
               <?php foreach ($rooms as $room) : ?>
                    <div> <?= ucfirst($room['standard']) ?>:
                         <input type="number" min="1" step="1" name="<?= $room['standard'] ?>" id="<?= $room['standard'] ?>">
                         <label for="<?= $room['standard'] ?>">current price: <?= $room['price'] ?></label>
                    </div>
               <?php endforeach ?>
               <?php if (isset($_POST)) {
                    foreach ($_POST as $standard => $price) {
                         if ($price != "") {
                              $update = $db->prepare('UPDATE standards SET price = :price WHERE standard = :standard');
                              $update->bindParam(':price', $price);
                              $update->bindParam(':standard', $standard);
                              $update->execute();
                         }
                    }
               } ?>
               <?php $features = $db->prepare('SELECT feature_name, price FROM features');
               $features->execute();
               $features = $features->fetchAll(PDO::FETCH_ASSOC); ?>
               <h3>Features:</h3>
               <?php foreach ($features as $feature) : ?>
                    <div> <?= ucfirst($feature['feature_name']) ?>:
                         <input type="number" min="1" step="1" name="<?= $feature['feature_name'] ?>" id="<?= $feature['feature_name'] ?>">
                         <label for="<?= $feature['feature_name'] ?>">current price: <?= $feature['price'] ?></label>
                    </div>
               <?php endforeach ?>
               <input type="submit" value="Update">
               <?php if (isset($_POST)) {
                    foreach ($_POST as $feature => $price) {
                         if ($price != "") {
                              $update = $db->prepare('UPDATE features SET price = :price WHERE feature_name = :feature_name');
                              $update->bindParam(':price', $price);
                              $update->bindParam(':feature_name', $feature);
                              $update->execute();
                         }
                    }
                    unset($_POST);
               } ?>
          </form>

     <?php
     endif;
     ?>
</div>


<?php require __DIR__ . ('/footer.php');
