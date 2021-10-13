<?php
/*
Erstellen Sie andererseits eine Suchmaske für einen User, worin er nach Büchern suchen kann.
 Folgende Filter soll er eingeben können:
•	Verlag
•	Autor
•	Buchtitel
•	ISBN

*/
include("includes/db.php");
require("includes/config.inc.php");
$such_gesamt="";
if (count($_POST)>0) {
  te($_POST);
$such=array();
if ($_POST['FIDVerlage']>0) {
  $such[]="tbl_bib_buecher.FIDVerlage = " .$conn->real_escape_string($_POST['FIDVerlage']);
}
if ($_POST['FIDAutor']>0) {
  $such[]="tbl_bib_buecher.FIDAutor = " .$conn->real_escape_string($_POST['FIDAutor']);
}
if (strlen($_POST['titel'])>0) {
  $such[]="tbl_bib_buecher.titel = '". $conn->real_escape_string($_POST['titel'])."'";
}
if (strlen($_POST['isbn'])>0) {
  $such[]="tbl_bib_buecher.ISBN= '". $conn->real_escape_string($_POST['isbn'])."'";
}
if (strlen($_POST['jahr'])>0) {
  $such[]="tbl_bib_buecher.Erscheinungsjahr=  '". $conn->real_escape_string($_POST['jahr'])."'";
}
if (count($such)>0) {
  $such_gesamt="
    WHERE(
      ". implode(" AND ",$such)."
      )
  ";
}else {
  $such_gesamt="";
}


}
 ?>
 <!DOCTYPE html>
 <html lang="de">
   <head>
     <meta charset="utf-8">
     <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
     <title>suchen</title>
   </head>
   <body>
     <form  method="post">


     <table  class="table table-striped">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Verlag</th>
      <th scope="col">Autor</th>
      <th scope="col">Title</th>
      <th scope="col">ISBN</th>
      <th scope="col">Jahr</th>
    </tr>
    <tr>
      <td>-</td>
      <td name="FIDVerlage" id="FIDVerlage"><?php echo zeigeVerlage(); ?></td>
      <td name="FIDAutor" id="FIDAutor"><?php echo zeigeAutoren(); ?></td>
      <td> <input type="text" name="titel"  value=""></td>
      <td> <input type="text" name="isbn"  value=""></td>
      <td> <input type="number" name="jahr"  value=""></td>
      <td><input type="submit" value="suchen"></td>
    </tr>
  </thead>
  <tbody>
  <?php

$sql="
  SELECT tbl_bib_buecher.* , tbl_bib_Autoren.Vorname, tbl_bib_Autoren.Nachname, tbl_bib_verlage.Verlagsname FROM tbl_bib_buecher
  INNER JOIN tbl_bib_Autoren ON tbl_bib_buecher.FIDAutor = tbl_bib_Autoren.idAutor
  INNER JOIN tbl_bib_verlage ON tbl_bib_buecher.FIDVerlage = tbl_bib_verlage.idVerlag
  ". $such_gesamt ."
";

$buecher= $conn->query($sql);

if ($buecher->num_rows > 0) {
  // output data of each row
  while($buech = $buecher->fetch_assoc()) {
    echo '
    <tr>
      <td></td>
      <td>'.$buech['Verlagsname'].'</td>
      <td>'.$buech['Vorname']. ' ' .$buech['Nachname'].'</td>
      <td>'.$buech['Titel'].'</td>
      <td>'.$buech['ISBN'].'</td>
      <td>'.$buech['Erscheinungsjahr'].'</td>
      <td><td>
    </tr>
    ';
  }
}
     ?>
  </tbody>
</table>
</form>
<?php
function zeigeAutoren(){
  global $conn;
  $sql="
  SELECT  tbl_bib_Autoren.idAutor ,tbl_bib_Autoren.Vorname , tbl_bib_Autoren.Nachname FROM tbl_bib_Autoren
  ";
  $autoren = $conn->query($sql);
  $r='<select name="FIDAutor" id="FIDAutor">';
if ($autoren->num_rows > 0) {
  // output data of each row
  while($autor = $autoren->fetch_assoc()) {
    $r.= '
      <option value="'.$autor['idAutor'] .'">'. $autor['Vorname']. ' ' . $autor['Nachname'].'</option>';
  }
}
$r.='</select>';
return $r;
}


function zeigeVerlage(){

  global $conn;
  $sql="
SELECT tbl_bib_verlage.Verlagsname, tbl_bib_verlage.idVerlag FROM tbl_bib_verlage
  ";
  $verlagen = $conn->query($sql);
  $r='<select name="FIDVerlage" id="FIDVerlage">';

if ($verlagen->num_rows > 0) {
  // output data of each row
  while($verlag = $verlagen->fetch_assoc()) {
    $r.= '
    <option value="'.$verlag['idVerlag'].'">'.$verlag['Verlagsname'].'</option>
    ';
  }
}
$r.='</select>';
return $r;
}
 ?>
   </body>
 </html>
