<?php
include("include/db.php");
require("include/config.inc.php");
// Listen Sie alle Bücher wie folgt auf:
// a. Buchtitel (aufsteigend sortiert)
// b. Autor(en)
// c. Verlag
// d. ISBN
// e. Erscheinungsdatum


 ?>
 <!DOCTYPE html>
 <html lang="de">
   <head>
     <meta charset="utf-8">
     <title>Büchliste</title>
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

     <ul>
<?php
  $sql="
  SELECT tbl_buecher.*, tbl_verlage.NameVerlage FROM tbl_buecher
  INNER JOIN tbl_verlage ON tbl_buecher.FIDVerlage = tbl_verlage.IDVerlage
  ORDER BY tbl_buecher.Titel ASC
  ";
  $buecherliste = $conn->query($sql) or die("Fehler in der Query:" . $conn->error);

    // output data of each row
    while($buch = $buecherliste->fetch_assoc()) {
      echo '
      <li> ' . $buch['Titel'].  ' - ' . $buch['ErscheinungsJahr'] . ' - ' . $buch['ISBN'] . ' -  Verlage:  ' . $buch['NameVerlage'];

      echo "<ul>";
        $sql="
        SELECT tbl_bucher_autor.* , tbl_autor.* FROM tbl_bucher_autor
        INNER JOIN tbl_autor ON tbl_bucher_autor.FIDAutor = tbl_autor.IDAutor
        WHERE(

          tbl_bucher_autor.FIDBucher= ". $buch['IDBucher'] . "
          )

        ";

        $autoren = $conn->query($sql) or die("Fehler in der Query:" . $conn->error);
        // te($autoren);
        while($autor = $autoren->fetch_assoc()) {

          echo '
            <li> Autor:  '.  $autor['Vorname'] . ' -  ' .  $autor['Nachname']. '</li>

          ';
        }

      echo  '</ul></li>';
    }



 ?>


     </ul>
   </body>
 </html>
