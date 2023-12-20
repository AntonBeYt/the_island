<?php


require __DIR__ . ('/header.php');
require __DIR__ . ('/hotelFunctions.php');
$db = new PDO('sqlite:booking.db');

$paymentQuery = 'UPDATE booking SET payment_code = :payment_code, subtotal = :subtotal WHERE id = :user_id';
echo $_POST['pay-code'];
if (isset($_POST['pay-code'])) {
     $result = htmlspecialchars($_POST['pay-code'], ENT_QUOTES);
     $result = isValidUuid($result);
     if ($result === true) {
          $client = new GuzzleHttp\Client();
          $validate = $client->request('POST', 'https://www.yrgopelag.se/centralbank/transferCode', ['form_params' => [
               'transferCode' => $_POST['pay-code'],
               'totalcost' => $_SESSION['subtotal']
          ]]);
          echo $validate->getStatusCode();

          $deposit = $client->request('POST', 'https://www.yrgopelag.se/centralbank/deposit', ['form_params' => [
               'user' => 'Anton',
               'transferCode' => $_POST['pay-code']
          ]]);
          echo $deposit->getStatusCode();
          echo "<pre>";
          var_dump($deposit->getBody());

          $payment = $db->prepare($paymentQuery);
          $payment->bindParam(':payment_code', $_POST['pay-code']);
          $payment->bindParam(':subtotal', $_SESSION['subtotal']);
          $payment->bindParam(':user_id', $_SESSION['user']);
          $payment->execute();

          // TODO: return confirmation of succesful booking
     } else {
          $_SESSION['error'] = "Your payment was refused, please try again";
          // $deleteBooking = $db->prepare('DELETE FROM booking WHERE id = :id');
          // $deleteBooking->bindParam(':id', $_SESSION['user']);
          // $deleteBooking->execute();
          // $deleteAddons = $db->prepare('DELETE FROM booking_features WHERE guest_id = :id');
          // $deleteAddons->bindParam(':id', $_SESSION['user']);
          // $deleteAddons->execute();
          // header('Location: index.php');
          //move deletion to index? if session id isset and paymentcode null?
     }
}
