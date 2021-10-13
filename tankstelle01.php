<?php
include("includes/db.php");
require("includes/config.inc.php");
$sqlw="";
if (count($_POST)>0) {
  te($_POST);
  $arr=array();
  if (strlen($_POST['idkunde'])>0) {
    $arr[]="tbl_kunde.IDKunde >='". $_POST['idkunde'] ."'";
  }
  if (strlen($_POST['idkunde'])>0) {
   $arr[]="tbl_kunde.IDKunde <= '". $_POST['idkunde'] ."'";
  }
  if (count($arr)>0) {
   $sqlw="
     WHERE(
       " . implode(" AND ",$arr) ."
       )

   ";
  }else {
    $sqlw="";
  }
}


 ?>
 <!DOCTYPE html>
 <html lang="de">
   <head>
     <meta charset="utf-8">
     <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

     <title>Kunden suchen</title>
     <style media="screen">
     .center {
      margin: auto;
      width: 50%;
      border: 2px solid gray;
      padding: 10px;
      margin-top: 3rem;
      }
     </style>
   </head>
   <body>
     <div class="center">
     <form class=""  method="post">
       <div class="mb-3">
        <label for="idkunde" class="form-label">Kundennummer:</label>
        <input type="number" class="form-control" id="idkunde" name="idkunde" >
      </div>
      <div class="mb-3">
       <input type="submit" class="form-control" value="suchen" >
     </div>
     </form>
     </div>
     <?php
     $sql = "
     SELECT * FROM tbl_kunde
     " . $sqlw . "
     ";
     echo "<ul>";
     $kunden = $conn->query($sql)or die("Fehler in der Queray:" . $conn->error);

     if ($kunden->num_rows > 0) {
       // output data of each row
       while($kunde = $kunden->fetch_assoc()) {

         $sql="
          SELECT tbl_verbrauch.IDbuchungs,tbl_verbrauch.FIDKunde,tbl_verbrauch.BuchungsDatum,tbl_verbrauch.FIDTreibstoff,SUM(tbl_verbrauch.Menge) AS summerMenge,SUM(tbl_verbrauch.preis) AS summePreis, tbl_treibstoff.* FROM tbl_verbrauch
          INNER JOIN tbl_treibstoff ON tbl_verbrauch.FIDTreibstoff = tbl_treibstoff.IDTreibstoff
          WHERE(
            tbl_verbrauch.FIDKunde = ". $kunde['IDKunde'] ."
            )
         ";
         $verbrauchten = $conn->query($sql)or die("Fehler in der Queray:" . $conn->error);
          while($verbraucht = $verbrauchten->fetch_assoc()) {

            echo '<li>Kundennummer: '.$kunde['IDKunde'].'</li>
            <li>Vorname: '.$kunde['Vorname'].'</li>
            <li>Nachname: '.$kunde['Nachname'].'</li>
            <li>GeburtsDatum: '.$kunde['GeburtsDatum'].'</li>
            <li>PLZ: '.$kunde['PLZ'].'</li>
            <li>Ort: '.$kunde['Ort'].'</li>
            <li>Telefon: '.$kunde['Telefon'].'</li>
            <ul>
            <li>summerMenge: '. $verbraucht['summerMenge'] .'</li>
            <li>summePreis :'. $verbraucht['summePreis'] .'</li>
            </ul><br>
                ' ;


          }

       }
     }else {
       echo "<p>Der kunde wurde nicht gefunden oder ungültige Eingabe</p>";
     }
     echo "</ul>";

      ?>
   </body>

 </html>
