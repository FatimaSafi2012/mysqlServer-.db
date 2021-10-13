<?php
include("include/db.php");
require("include/config.inc.php");

// 'Listen Sie alle aktuell ausgeborgten Bücher wie untenstehend auf. Weiters soll es eine
// Möglichkeit geben, das Datumsintervall einzugrenzen, indem man das Anfangsdatum "ab" einen
// bestimmten Wert und "bis zu" einem bestimmten Wert eingrenzen kann.
// a. Ausborgedatum (absteigend sortiert)
// b. Buchtitel
// c. Vor- und Nachname des Ausborgers  bei Klick auf dessen Name sollen wiederum seine
// Detailinformationen eingeblendet werden
if (count($_POST)>0) {
  print_r($_POST);
}

 ?>
<!DOCTYPE html>
<html lang="de">
  <head>
    <meta charset="utf-8">
    <script src="js/jquery-3.5.1.min.js"></script>
    <title>Bibliotheksverwaltung: Ausborgeliste</title>
    <style>
.details{
  display: none;
}
    </style>
  </head>
  <body>
    <nav>
      <ul>
        <li><a href="userListe.php"> userListe</a></li>
        <li><a href="ausburgteListe.php"> Ausborgeliste</a></li>
        <li><a href="buchliste.php"> Büchliste</a></li>
        <li><a href="buchFilter.php"> Filtrn</a></li>
      </ul>
    </nav>
    <form method="post">
      <label for="ab">Datum ab:</label>
      <input type="date" name="ab" value="">
      <label for="bis">Datum bis:</label>
      <input type="date" name="bis" value="">

      <input type="submit" name="" value="ab/bis filtern">
    </form>
    <ul>
      <?php
$arr= array("tbl_ausgeborgteliste.Ende IS NULL");
if (count($_POST)>0) {
    if (strlen($_POST["ab"])>0) {
    $arr[]= "tbl_ausgeborgteliste.Beginn >='". $_POST['ab'] ."'";
    }
    if (strlen($_POST['bis'])>0) {
      $arr[]="tbl_ausgeborgteliste.Beginn <='". $_POST['bis']."'";
    }
  }
      $sql="
      SELECT tbl_ausgeborgteliste.Beginn, tbl_buecher.Titel, tbl_user.* FROM tbl_ausgeborgteliste
      INNER JOIN tbl_buecher ON tbl_ausgeborgteliste.FIDBucher = tbl_buecher.IDBucher
      INNER JOIN tbl_user ON tbl_ausgeborgteliste.FIDUser = tbl_user.IDUser

      WHERE(
        " . implode(" AND ",$arr) . "
      )
        ORDER BY tbl_ausgeborgteliste.Beginn DESC
      ";
      // te($sql);
      echo "<h3> AktuellAusborgeliste</h3>";
      $buecherliste=$conn->query($sql) or die("Fehler in der Query:" . $conn->error);
      while ($buch=$buecherliste->fetch_assoc()) {
        echo '<li>
        '. $buch['Beginn']. ' : ' . $buch['Titel'] . ', ausgeborgt von <a onclick="$(this).nextAll().toggle(\'.details\');">' . $buch['Vorname'] . ' ' .$buch['Nachname'] . '</a>
        <div class="details">
        '. $buch['EmailAdresse'].'<br>
        '. $buch['Adresse'].' , '. $buch['PLZ']. ' ' . $buch['Ort'] .'
        </div></li>';
      }
       ?>
    </ul>
  </body>
</html>
