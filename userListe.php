<?php
include("include/db.php");
require("include/config.inc.php");
// 1. Listen Sie alle User auf.
// a. Bei Klick auf einen Link "Ausborgeliste" neben dem Namen des Users sollen zunächst alle
// seine aktuell ausgeborgten Bücher (sortiert nach dem Ausborgedatum absteigend)
// aufgelistet werden; darunter sollen alle bereits wieder zurückgegebenen Bücher (sortiert
// nach dem Ausborgedatum absteigend) aufgelistet werden.
// b. Bei Klick auf den Namen des Users sollen dessen Detailinformationen (Adresse, Email,
// etc.) eingeblendet werden (auf derselben Seite)

 ?>
<!DOCTYPE html>
<html lang="de">
  <head>
    <meta charset="utf-8">
    <title>Bibliotheksverwaltung</title>
    <script src="js/jquery-3.5.1.min.js"></script>
    <style>
      .dataial, .ausgeborgte {
        display: none;
      }
    </style>
  </head>
  <body>
    <nav>
      <ul>
        <li><a href="userListe.php"> zurück zur Startseite</a></li>
        <li><a href="ausburgteListe.php"> Ausborgeliste</a></li>
        <li><a href="buchliste.php"> Büchliste</a></li>
        <li><a href="buchFilter.php"> Filtrn</a></li>

      </ul>
    </nav>
    <ul>
      <?php
      $sql="
      SELECT * FROM tbl_user
      ";
   $userliste = $conn->query($sql);


    // output data of each row
    while($user = $userliste->fetch_assoc()) {

      echo '

      <li>
      <a onclick="$(this).nextAll(\'.dataial\').toggle();"> '. $user['Vorname']. ' ' . $user['Nachname'] .' </a>
      <a onclick="$(this).nextAll(\'.ausgeborgte\').toggle();">Ausborgeliste</a>
      <div class="dataial">
      '.$user['EmailAdresse'].'<br>
      '. $user['Adresse'] . ',' . ' '. $user['PLZ'].'  '.$user['Ort'].'
      </div>
      <ul class="ausgeborgte">';

      echo "<h3>ausgeborgte büchern</h3>";

      // aktuell ausgeborgte Liste
      $sql="
        SELECT tbl_ausgeborgteliste.Beginn, tbl_buacher.Titel FROM tbl_ausgeborgteliste
        INNER JOIN tbl_buacher ON tbl_ausgeborgteliste.FIDBuch = tbl_buacher.IDBuacher
        WHERE(
          tbl_ausgeborgteliste.FIDUser = ". $user['IDUser']." AND
          tbl_ausgeborgteliste.Ende IS NULL
          )
          ORDER BY tbl_ausgeborgteliste.Beginn DESC
      ";
      $buecherliste=$conn->query($sql) or die("Fehler in der Querq:" . $conn->error);
      while ($buecherlist=$buecherliste->fetch_assoc()) {
        echo '
          <li> '. $buecherlist['Beginn'] . ' - ' . $buecherlist['Titel']. '  </li>
        ';
      }

      // zurückgegebene büchern
      echo "<h3>zurückgegebene büchern</h3>";
      $sql="
SELECT tbl_ausgeborgteliste.Beginn, tbl_ausgeborgteliste.Ende, tbl_buacher.Titel FROM tbl_ausgeborgteliste
INNER JOIN tbl_buacher ON tbl_ausgeborgteliste.FIDBuch = tbl_buacher.IDBuacher
WHERE(
  tbl_ausgeborgteliste.FIDUser=". $user['IDUser']." AND
  tbl_ausgeborgteliste.Ende IS NOT NULL
  )
  ORDER BY tbl_ausgeborgteliste.Beginn DESC

  ";
  $buecherlisteZruck=$conn->query($sql) or die("Fehler in der Querq:" . $conn->error);
  while ($buchZurckList=$buecherlisteZruck->fetch_assoc()) {
    echo '<li> ' . $buchZurckList['Beginn'] . ' Bis ' . $buchZurckList['Ende'] . ' , ' . $buchZurckList['Titel'] . '</li>';
  }


      echo "</ul> </li>";

  }


      ?>
    </ul>

  </body>
</html>
