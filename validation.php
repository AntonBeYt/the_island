<?php


require __DIR__ . ('/header.php');
require __DIR__ . ('/hotelFunctions.php');
$db = new PDO('sqlite:booking.db');

$paymentQuery = 'UPDATE booking SET payment_code = :payment_code, subtotal = :subtotal WHERE id = :user_id';
// echo $_POST['pay-code'];
if (isset($_POST['pay-code'])) {
     $result = htmlspecialchars($_POST['pay-code'], ENT_QUOTES);
     $result = isValidUuid($result);
     if ($result === true) {
          $client = new GuzzleHttp\Client();
          $validate = $client->request('POST', 'https://www.yrgopelag.se/centralbank/transferCode', ['form_params' => [
               'transferCode' => $_POST['pay-code'],
               'totalcost' => $_SESSION['subtotal']
          ]]);
          $check = json_decode($validate->getBody(), true);
          if ($_SESSION['subtotal'] !== $check['amount']) {
               $_SESSION['error'] = "Your payment code does not match your subtotal, please try again";
               header("Location: payment.php");
               die;
          }
          $deposit = $client->request('POST', 'https://www.yrgopelag.se/centralbank/deposit', ['form_params' => [
               'user' => 'Anton',
               'transferCode' => $_POST['pay-code']
          ]]);
          $payment = $db->prepare($paymentQuery);
          $payment->bindParam(':payment_code', $_POST['pay-code']);
          $payment->bindParam(':subtotal', $_SESSION['subtotal']);
          $payment->bindParam(':user_id', $_SESSION['user']);
          $payment->execute();
          echo "<script type='text/javascript'>  window.location='success.php'; </script>";
          // header('Location: success.php');
     } else {
          $_SESSION['error'] = "Your payment was refused, please try again";
          echo "<script type='text/javascript'>  window.location='payment.php'; </script>";
          // header('Location: payment.php');
     }
}
