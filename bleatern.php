<?php
require("includes/incluad.inc.php");
// SELECT MIT TABLE DIE INFORMATION IN MEHREHRE SEITE mit user eingabe: Die Datensätze zB. 5 auf eine Seite


// Verbindung mit DBserver
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_phpmyadmin";
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_errno>0) {
  die("Fehler im Verbindung mit datenbank Server: " . $conn->connect_error);
}else {
  // echo "erfolgreich";
}

// die anzahl des Datensaetze die ich anzeigen will
$anzDatensaetzeProSeite=5;
//von welchem seite sollen wir beginnen zum Bleatten

$seite=1; // da soll user eine mäglichkeit haben auf button klicken und die seite sehen dafür brachen wir eine Fomular
// wie viele einträge(zeilen) allegemin eine tbl besetzt
// schiken wir ein sql stetmmant zum db und sagen select alle zeille und speichen in variable cnt
$sql="
SELECT COUNT(*) AS cnt
FROM tbl_user
";

$daten = $conn->query($sql) or die("Fehler in der Query: ". $conn->error);
// da kommt nur eine zeile zurück weil nur eine Zeille ist
$zeile=$daten->fetch_object();
$anzDatenSaetzeGesamt = $zeile->cnt;
// die maxmale Seite
$maxSaete = ceil($anzDatenSaetzeGesamt/$anzDatensaetzeProSeite);

// da schike ich der Formular zum DBserver
if (count($_POST)>0) {
  te($_POST);
  // da überschreibe ich $seite in was user eingibt
  $seite=$_POST['neueSeite'];
}

 ?>
<!DOCTYPE html>
<html lang="de">
  <head>
    <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <title></title>
    <style>
      .table{
border: 3px gray solid;
      }
    </style>
  </head>
  <body>
    <form class="" method="post">
      <!-- minmal wert für user 1  -->
      <input id="neueSeite" type="number" name="neueSeite" value="<?php echo ($seite); ?>" min=1 max="<?php echo ($maxSaete); ?>">
      <input type="submit" name="" value="Blättern">
    </form>
    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">ID User</th>
          <th scope="col">Emailadresse</th>
          <th scope="col">Passwort</th>
          <th scope="col">Vorname</th>
          <th scope="col">Nachname</th>
          <th scope="col">GebDatum</th>
          <th scope="col">RegZeitPunkt</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // limit befehl sagt ab welche Datensatz , wie viele  Datensaetze soll geliefert werden 0,5
$sql="SELECT * FROM tbl_user
      LIMIT " .  ($seite-1)*$anzDatensaetzeProSeite .   " , " . $anzDatensaetzeProSeite . "
";
// te($sql);

$result = $conn->query($sql) or die("Fehler in der Query: ". $conn->error);

if ($result->num_rows > 0) {

  while($row = $result->fetch_object()) {
    echo '    <tr>
              <td>'.$row->IdUser.'</td>
              <td>'.$row->Emailadresse.'</td>
              <td>'.$row->Passwort.'</td>
              <td>'.$row->Vorname.'</td>
              <td>'.$row->Nachname.'</td>
              <td>'.$row->GebDatum.'</td>
              <td>'.$row->RegZeitPunkt.'</td>
            </tr>
       ';
  }
}

         ?>
      </tbody>
    </table>
  </body>
</html>
