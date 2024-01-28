<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "gestion");

if (!$conn) {
  die("Erreur de connexion : " . mysqli_connect_error());
}

include('cadre.php');
?>
<html>

<body>
    <div class="corp">
    </div>
</body>

</html>
