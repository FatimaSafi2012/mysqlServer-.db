<?php
include("includes/db.php");
require("includes/config.inc.php");

$sqlw="";
if (count($_POST)>0) {
  // te($_POST);
  $arr=array();
  if (strlen($_POST['kunderNumer'])>0) {
    $arr[]="tbl_kunde.IDKunde  >= '". $_POST['kunderNumer']."'";
  }
  if (strlen($_POST['kunderNumer'])>0) {
    $arr[]="tbl_kunde.IDKunde  <='" . $_POST['kunderNumer'] . "'";
  }
  if (count($arr)>0) {
    $sqlw ="
    WHERE(
      " .  implode(" AND ",$arr) . "
      )

    ";
  }
  else {
    $sqlw ="";
  }
}

 ?>
<!DOCTYPE html>
<html lang="de">
  <head>
    <meta charset="utf-8">
    <title>TankstelleVerwaltung-kunden</title>
    <style media="screen">
      body{
        font-size: 18px;
      }
      *{
        box-sizing: border-box;
      }
    </style>
  </head>
  <body>

    <h1>Such nach Kundennummer</h1>
    <form method="post">
      <label for="kunderNumer">Kundennummer</label>
      <input type="number" min="0" max="99999"name="kunderNumer" id="kunderNumer" value="">
      <input type="submit" name="" value="suchen"><br><br>



    <table class="table">
    <tbody>
    <?php
    $sql="
    SELECT * FROM tbl_kunde
    " . $sqlw . "
    ";
    $kunden = $conn->query($sql) or die("Fehler in der Query:" . $conn->error);

    if ($kunden->num_rows > 0) {
      // output data of each row
      while($kunde= $kunden->fetch_assoc()) {

        $sql="
    SELECT IDbuchungs ,preis, Menge ,SUM(preis) as preis ,SUM(Menge) as menge FROM tbl_verbrauch
       WHERE(
      tbl_verbrauch.FIDKunde= ". $kunde['IDKunde'] ."

      )

        ";
        $summen = $conn->query($sql) or die("Fehler in der Query:" .$conn->error);

  // output data of each row
  while($summ = $summen->fetch_assoc()) {

  echo "<tr>
  <td> Treibstoffverbrauch:". $summ['menge'] ."</td></tr>
  <tr><td> GesamtPreis:". $summ['preis'] ."</td></tr><br>
  ";

}

        echo "
    <tr>
      <td> Kundennummer: ". $kunde['IDKunde']."</td></tr>
      <tr><td> Vorname: ". $kunde['Vorname']. "</td></tr>
       <tr><td>Nachname: ". $kunde['Nachname']. "</td></tr>
    <tr><td> GeburtsDatum: ". $kunde['GeburtsDatum']. "</td></tr>
      <tr><td> Staße: ". $kunde['Strasse']. "</td></tr>
      <tr><td> PLZ: ". $kunde['PLZ']. "</td></tr>
      <tr><td> Ort:" . $kunde['Ort']. "</td></tr>
      <tr><td>Telefon: ". $kunde['Telefon']."</td></tr><br><br>

        ";

    }
  }else {
    echo "Der Kunde wurde nicht gefunden oder ungültige Eingabe!.";
  }

     ?>
    </tbody>
    </table>


  </body>
    </form>
</html>
