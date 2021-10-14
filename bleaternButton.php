<?php
require("includes/incluad.inc.php");
$servername = "localhost";
$username = "root";
$password = "";
$datenbankname="db_phpmyadmin";

// Verbindung mit db server
$conn = new mysqli($servername, $username, $password,$datenbankname);

// Check connection
if ($conn->connect_errno>0) {
  die("Fehler in Verbindung mit DatenBank server: " . $conn->connect_error);
}
// echo "Verbindung successfully";

// wie vile datenSetze darf in jedem bleatter Sein
$andatenSatzProSeite=5;
$seite=1;
// anzahl von gesammte zeile
$sql="
  SELECT COUNT(*) AS cun FROM tbl_user
";
$daten = $conn->query($sql) or die("fehler in der Query: " .$conn->error);
$zeile=$daten->fetch_object();
$anzDatenSaetzeGesamt=$zeile->cun;
$maxSaete=ceil($anzDatenSaetzeGesamt/$andatenSatzProSeite);


if (count($_POST)>0) {
  te($_POST);
  $seite=$_POST['neueSeite'];
}
 ?>
 <!DOCTYPE html>
 <html lang="de">
   <head>
     <meta charset="utf-8">
     <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
     <title></title>
     <script type="text/javascript">
    function blaettere(richtung){
      var aktuelleSeite= parseInt(document.getElementById("neueSeite").value);

      if (aktuelleSeite + richtung>0 && aktuelleSeite + richtung <=<?php echo ($maxSaete); ?>) {
        var neueSeite= aktuelleSeite + richtung;
        // da koennen wir mit blettern
        document.getElementById("neueSeite").value=neueSeite;
        // und da schieken wir den formular zum server seite mit id in Fomular
        document.getElementById("frm").submit();

      }
     }

     </script>
   </head>
   <body>
     <form class="" method="post" id="frm">
       <!-- unicode html -->
      <button type="button" onclick=blaettere(-1);>&lsaquo;</button>
       <input type="number" name="neueSeite" id="neueSeite" value="<?php echo ($seite); ?>" min=1 max="<?php echo ($maxSaete); ?>" readonly>
       <button type="button" onclick=blaettere(1);>&rsaquo;</button>
       <!-- <input type="submit" name="" value="Bleattern"> -->
       <!-- das submit brauchen wir nicht weil wir mit js formular geschikt  -->
     </form>
     <table class="table table-striped">
       <thead>
         <tr>
           <th scope="col">IdUser</th>
           <th scope="col">Vorname</th>
           <th scope="col">Nachname</th>
           <th scope="col">Emailadresse</th>
           <th scope="col">Passwort</th>
           <th scope="col">GebDatum</th>
           <th scope="col">RegZeitPunkt</th>
         </tr>
       </thead>
       <tbody>
         <?php

            $sql="
              SELECT * FROM tbl_user
              ORDER BY Nachname ASC, Vorname DESC
              LIMIT ". ($seite-1)*$andatenSatzProSeite ."," . $andatenSatzProSeite . "

            ";

 $result = $conn->query($sql) or die("fehler in der Query: " .$conn->error);

if ($result->num_rows > 0) {

  while($row = $result->fetch_object()) {
    echo '
    <tr>
      <td>'. $row->IdUser.'</td>
      <td>'. $row->Vorname.'</td>
      <td>'. $row->Nachname.'</td>
      <td>'. $row->Emailadresse.'</td>
      <td>'. $row->Passwort.'</td>
      <td>'. $row->GebDatum.'</td>
      <td>'. $row->RegZeitPunkt.'</td>
    </tr>


    ';


  }
}
          ?>


       </tbody>
     </table>
    </body>
 </html>
