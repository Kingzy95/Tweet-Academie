<?php
  include '../core/init.php';
if (!empty($getFromU)) {
  $getFromU->logout();
}
  if ($getFromU->loggedIn() === false) {
    header('Location:'.BASE_URL.'index.php');
  }
?>
