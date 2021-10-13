<?php

if (!(isset($_SESSION['logged']) && $_SESSION['logged']==1)) {
  header("loction: index.php");
}

 ?>
