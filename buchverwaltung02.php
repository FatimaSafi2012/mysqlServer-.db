<?php
/*
In jedem Fall sollen dem User alle Bücher mit den eingegebenen Filtern in Form einer Tabelle angezeigt werden:
Verlag	Autor	Buchtitel	ISBN	Jahr
Galileo Press	Mutz Uwe	„PHP“	…	2016
Addison-Wesley	Mutz Uwe	„Flash“	…	2015
Galileo Press	Heinz Fischer	„Österreich“	…	2014
*/

require("includes/db.php");
include("includes/config.inc.php");

$msg="";
if (count($_POST)>0) {
   // te($_POST);
  switch ($_POST['wasTun']) {
    case 'einfuegen':
    $sql = "
    INSERT INTO tbl_bib_verlage (Verlagsname, Beschreibung)
    VALUES (
    '". $_POST['vorlage']."',
    '". $_POST['beschreibung']."'
      )";

if ($conn->query($sql) === TRUE) {
  $msg="<p> Ihre Antrage ist erfolgreich eingefügt</p>";
} else {
  $msg="<p> Ihre Antrage konnte leider nicht erfolgreich eingefügt werden</p>";
}
      break;



case 'löschen':
$id=$_POST['welcheID'];
$sql = "
DELETE FROM tbl_bib_verlage
 WHERE(
  idVerlag = ". $id ."
   ) ";

if ($conn->query($sql) === TRUE) {
  $msg="<p> Ihre Antrage ist erfolgreich gelöscht geworden</p>";
} else {
  $msg="<p> Ihre Antrage konnte leider nicht erfolgreich gelöscht werden</p>";
}
  break;

  case 'aktualiseirn':
  $id=$_POST['welcheID'];

  $sql = "
  UPDATE tbl_bib_verlage SET
   Verlagsname='". $_POST['verlage_'. $id]."',
   Beschreibung='". $_POST['beschreibung_'. $id]."'
    WHERE(
      idVerlag =". $id ."
      )";

if ($conn->query($sql) === TRUE) {
  $msg="<p> Ihre Antrage ist erfolgreich geändert geworden</p>";
} else {
  $msg="<p> Ihre Antrage konnte leider nicht erfolgreich geändert werden</p>";
}
    break;


    // ----------------------------------------------------//
    case 'einfuegenAutorn':
    $sql = "
    INSERT INTO tbl_bib_autoren
     (Vorname, Nachname, Kommentar)
    VALUES (
      '".$_POST['vornameAutor']."',
      '".$_POST['NachnameAutor']."',
      '".$_POST['kommentarAutor']."'
      )";

if ($conn->query($sql) === TRUE) {
  $msg= "<p>Ihre Antrage ist erfolgreich eingefügt</p>";
} else {
  $msg= "<p>Ihre Antrage konnte leider nicht erfolgreich eingefügt</p>";
}
      // code...
      break;


      case 'loschenAutoren':
      $id=$_POST['welcheID'];
      $sql = "
      DELETE FROM tbl_bib_autoren
       WHERE(
        idAutor=". $id ."
         )";

      if ($conn->query($sql) === TRUE) {
        $msg= "<p>Ihre Antrage ist erfolgreich gelöscht</p>";
      } else {
        $msg= "<p>Ihre Antrage konnte leider nicht erfolgreich gelöscht werden</p>";
      }
    break;


    case 'aktualiseirnAutor':
    $id=$_POST['welcheID'];
    $sql = "
    UPDATE tbl_bib_autoren SET
     Vorname='". $_POST['vornameAutor_' . $id ]."',
     Nachname='". $_POST['NachnameAutor_' . $id ]."',
    Kommentar='". $_POST['kommentarAutor_' . $id ]."'
     WHERE(
    idAutor =". $id ."
       )";

    if ($conn->query($sql) === TRUE) {
      $msg= "<p>Ihre Antrage ist erfolgreich geändert</p>";
    } else {
      $msg= "<p>Ihre Antrage konnte leider nicht erfolgreich geändert werden</p>";
    }
      break;



      case 'einfuegenBuchern':

      $sql = "
      INSERT INTO tbl_bib_buecher(FIDVerlag, FIDAutor, Titel, ISBN,Erscheinungsjahr)
VALUES
 (
   '". $_POST['idVerlag']."',
  '". $_POST['idAutor']."',
   '". $_POST['titel']."',
   '". $_POST['isbn']."',
   '". $_POST['number']."'
   )
 ";

if ($conn->query($sql) === TRUE) {
  $msg= "<p>Ihre Antrage ist erfolgreich eingefügt</p>";
} else {
  $msg= "<p>Ihre Antrage konnte leider nicht erfolgreich eingefügt werden</p>";
}

        break;

case 'loschenBuchern':
$id=$_POST['welcheID'];
$sql = "
DELETE FROM tbl_bib_buecher
 WHERE(
   idBuch =". $id ."
   )";

if ($conn->query($sql) === TRUE) {
  $msg= "<p>Ihre Antrage ist erfolgreich gelöscht</p>";
} else {
  $msg= "<p>Ihre Antrage konnte leider nicht erfolgreich gelöscht werden</p>";
}
  // code...
  break;

  case 'aktualiseirnBuchern':
  $id=$_POST['welcheID'];
  $sql = "
  UPDATE tbl_bib_buecher SET
   FIDVerlag='". $_POST['idVerlag']."',
   FIDAutor='". $_POST['idAutor']."',
   Titel='". $_POST['titel_'.$id]."',
   ISBN='". $_POST['isbn_'.$id]."',
   Erscheinungsjahr='". $_POST['jahr_'.$id]."'
    WHERE(
      idBuch=" .  $id . "
      )";

if ($conn->query($sql) === TRUE) {
  $msg= "<p>Ihre Antrage ist erfolgreich geändert</p>";
} else {
  $msg= "<p>Ihre Antrage konnte leider nicht erfolgreich geändert werden</p>";
}
    // code...
    break;

case 'logout':
// Initialize the session.
// If you are using session_name("something"), don't forget it now!
session_start();

// Unset all of the session variables.
$_SESSION = array();

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finally, destroy the session.
session_destroy();
header("location: index.php");
  break;
    default:
      // code...
      break;
  }
}
 ?>
 <!DOCTYPE html>
 <html lang="de">
   <head>
     <meta charset="utf-8">
     <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
<script type="text/javascript">
  function einfuegen(){
    document.getElementById("wasTun").value="einfuegen";
    document.getElementById("frm").submit();
  }
  function loschen(loscheID){
    if (confirm("Wollen Sie wirklich der Datensatz löschen?")) {
      document.getElementById("wasTun").value="löschen";
      document.getElementById("welcheID").value=loscheID;
      document.getElementById("frm").submit();
    }
  }

function aktualiseirn(aktualisierteID){
  document.getElementById("wasTun").value="aktualiseirn";
  document.getElementById("welcheID").value=aktualisierteID;
  document.getElementById("frm").submit();
}

function einfuegenAutorn(){
  document.getElementById("wasTun").value="einfuegenAutorn";
  document.getElementById("frm").submit();
}


function loschenAutoren(loscheID){
  if (confirm("wollen Sie wirklich der Datensatz löschen?")) {
    document.getElementById("wasTun").value="loschenAutoren";
    document.getElementById("welcheID").value=loscheID;
    document.getElementById("frm").submit();

  }
}

function aktualiseirnAutor(aktualisierteID){

  document.getElementById("wasTun").value="aktualiseirnAutor";
  document.getElementById("welcheID").value=aktualisierteID;
  document.getElementById("frm").submit();
}

function einfuegenBuchern(){
  document.getElementById("wasTun").value="einfuegenBuchern";
  document.getElementById("frm").submit();
}
function loschenBuchern(loscheID){
  document.getElementById("wasTun").value="loschenBuchern";
  document.getElementById("welcheID").value=loscheID;
  document.getElementById("frm").submit();
}

function aktualiseirnBuchern(IDaktualiseirnBuchern){
  document.getElementById("wasTun").value="aktualiseirnBuchern";
  document.getElementById("welcheID").value=IDaktualiseirnBuchern;
  document.getElementById("frm").submit();
}

function logout(){
  document.getElementById("wasTun").value="logout";
  document.getElementById("frm").submit();
}
</script>
<style >
  /* .container{
margin: auto;
 width: 50%;
 border: 3px solid gray;
 padding: 10px;

  } */
</style>

     <title></title>
   </head>
   <body>
       <?php echo ($msg); ?>
       <div class="container">
     <form id="frm" method="post" >
       <input type="hidden" name="wasTun" id="wasTun" value="">
       <input type="hidden" name="welcheID" id="welcheID" value="">
       <input type="button" name="" class="table table-striped table-hover" onclick="logout();" value="logout">
     <table class="table table-striped table-hover">
  <thead>
    <h2>Verlage</h2>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Verlagename</th>
      <th scope="col">Beschreibung</th>
      <th></th>
      <th></th>

    </tr>
    <tr>
      <td scope="col">-</td>
      <td scope="col"><input type="text" name="vorlage" value=""></td>
      <td scope="col"> <input type="text" name="beschreibung" value=""></td>
    <td><button type="button" onclick="einfuegen();" name="button">INS</button></td>
    <td></td>
    </tr>


  </thead>
  <tbody>
    <?php
$sql="

SELECT * FROM tbl_bib_verlage
";
$verlagen = $conn->query($sql);

if ($verlagen->num_rows > 0) {
  // output data of each row
  while($verlage = $verlagen->fetch_assoc()) {
    echo '
    <tr>
    <td>'. $verlage['idVerlag'] .'</td>
      <td><input type="text" value="'. $verlage['Verlagsname'] .'" name="verlage_'. $verlage['idVerlag'] .'"></td>
      <td><input type="text" value="'. $verlage['Beschreibung'] .'" name="beschreibung_'. $verlage['idVerlag'] .'"></td>
      <td><button type="button" onclick="loschen('. $verlage['idVerlag'] .');">DEL</button></td>
      <td><button type="button" onclick="aktualiseirn('. $verlage['idVerlag'] .');">UPD</button></td>

    </tr>


    ';
}
}
     ?>
  </tbody>



</table>


<h2>Autoren</h2>

<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Vorname</th>
      <th scope="col">Nachname</th>
      <th scope="col">Kommentar</th>
      <th></th>
      <th></th>
    </tr>
    <tr>
      <td></td>
      <td> <input type="text" name="vornameAutor" value=""></td>
      <td> <input type="text" name="NachnameAutor" value=""></td>
      <td> <input type="text" name="kommentarAutor" value=""></td>
      <td> <button type="button" onclick="einfuegenAutorn();" name="button">INS</button></td>
      <td></td>
    </tr>
  </thead>
  <tbody>
    <?php

$sql="
  SELECT * FROM tbl_bib_autoren

";
$autoren= $conn->query($sql);

if ($autoren->num_rows > 0) {
  // output data of each row
  while($autor = $autoren->fetch_assoc()) {
    echo '
    <tr>
      <td>'.$autor['idAutor'].'</td>
      <td><input type="text" value="'.$autor['Vorname'].'" name="vornameAutor_'.$autor['idAutor'].'"></td>
      <td><input type="text" value="'.$autor['Nachname'].'" name="NachnameAutor_'.$autor['idAutor'].'" ></td>
      <td><input type="text" value="'.$autor['Kommentar'].'" name="kommentarAutor_'.$autor['idAutor'].'"></td>
      <td><button type="button" onclick="loschenAutoren('.$autor['idAutor'].');">DEL</button></td>
      <td><button type="button" onclick="aktualiseirnAutor('.$autor['idAutor'].');">UPD</button></td>
    </tr>

    ';
  }
}
     ?>
  </tbody>



</table><br><br>
<table  class="table table-striped">
  <thead>
      <h2>Bücher</h2>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">VerlageName</th>
      <th scope="col">Autor</th>
      <th scope="col">Titel</th>
      <th scope="col">ISBN</th>
      <th scope="col">Erscheinungsjahr</th>

    </tr>
    <tr>
      <td scope="col">-</td>
      <td scope="col"><?php echo (zeigeVerlage()); ?></td>
      <td scope="col"><?php echo (zeigeAutoren()); ?></td>
      <td scope="col"> <input type="text" name="titel" value=""></td>
      <td scope="col"><input type="text" name="isbn" value=""></td>
      <td scope="col"><input type="number" name="number" value=""></td>
      <td scope="col"><button type="button" onclick="einfuegenBuchern();">INS</button></td>

    </tr>


  </thead>
  <tbody>
    <?php
    $sql = "
    SELECT * FROM tbl_bib_buecher
    ";
    $buechern = $conn->query($sql);

    if ($buechern->num_rows > 0) {
      // output data of each row
      while($buecher = $buechern->fetch_assoc()) {
        echo '
        <tr>
          <td>'. $buecher['idBuch'] .'</td>
          <td  id="idVerlag" name="idVerlag">
          '. zeigeVerlage() .'</td>

          <td id="idAutor" name="idAutor">
          '. zeigeAutoren() .'
          </td>
          <td><input type="text" value="'. $buecher['Titel'] .'" name="titel_'. $buecher['idBuch'] .'"></td>
          <td><input type="text" value="'. $buecher['ISBN'] .'" name="isbn_'. $buecher['idBuch'] .'"></td>
          <td><input type="number" value="'. $buecher['Erscheinungsjahr'] .'" name="jahr_'. $buecher['idBuch'] .'"></td>
          <td><button type="button" onclick="aktualiseirnBuchern('. $buecher['idBuch'] .');">UPD</button></td>
          <td> <button type="button" onclick="loschenBuchern('. $buecher['idBuch'] .');">DEL</button></td>
        </tr>
        ';
      }
    }


     ?>
  </tbody>
</table>

</form>
</div>

<?php

function zeigeVerlage(){

  global $conn;
  $sql="
SELECT * FROM tbl_bib_verlage
  ";
  $verlagen = $conn->query($sql);

  $r='
  <select id="idVerlag" name="idVerlag" >
  ';
  while ($verlage = $verlagen->fetch_assoc()) {
    $r.='<option value="'.$verlage['idVerlag'] .'">'.$verlage['Verlagsname'].'</option>';
  }
$r.='</select>';
return $r;

}

function zeigeAutoren(){
  global $conn;
  $sql="
  SELECT * FROM tbl_bib_autoren
  ";
  $atuoren = $conn->query($sql);
  $r='<select id="idAutor" name="idAutor">';
if ($atuoren->num_rows > 0) {
  // output data of each row
  while($autor = $atuoren->fetch_assoc()) {
    $r.= '<option value="'. $autor['idAutor'].'">'. $autor['Vorname'] .  ' ' . $autor['Vorname'] . '</option>';
  }
}
$r.='</select>';
return $r;

}
 ?>
</body>
 </html>
