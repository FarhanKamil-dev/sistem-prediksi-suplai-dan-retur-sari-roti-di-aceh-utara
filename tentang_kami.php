<?php

session_start();

if (!isset($_SESSION["username"])) {
  header("Location: login.php");
}

?>

<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Prediksi -Sari Roti</title>
  <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css'>
  <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <!-- partial:index.partial.html -->
  <?php
  include_once 'sidebar.php';
  ?>

  <div class="content-container">

    <div class="container-fluid">

      <!-- Main component for a primary marketing message or call to action -->
      <div class="jumbotron">
        <h2>Tentang Kami</h2>
        <p>Sistem prediksi data Sari Roti di Aceh Utara ini dibuat oleh :
          <div style="display:flex; justify-content: space-around;">
            <div class="card" style="width:300px">
              <img class="card-img-top" src="img/Farhan.jpg" alt="Card image" style="width: 300px; height: 300px; object-fit: cover;">
              <div class="card-body">
                <h4 class="card-title">Farhan Kamil</h4>
                <p class="card-text">TI-4B</p>
              </div>
            </div>


        </div>

      </div>
    </div>
    <!-- partial -->
    <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
  </body>
  </html>