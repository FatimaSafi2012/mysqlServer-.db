<?php
  include("include/db.php");
  require("include/config.inc.php");

//   Erstellen Sie eine Suchmöglichkeit für Bücher nach:
// a. Buchtitel und/oder
// b. Erscheinungsjahr



 ?>
 <!DOCTYPE html>
 <html lang="de">
   <head>
     <meta charset="utf-8">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
     <title></title>
   </head>
   <body>
     <form method="post">
       <label for="buch">Buchtitel</label>
       <input type="text" name="buch" id="buch" value="">
       <label for="jahr">Erscheingunsjahr</label>
       <input type="number" name="jahr" id="jahr" value="">
       <input type="submit" name="" value="filtern">
     </form>
    <?php
        $sqlw = "";
    if (count($_POST)>0) {
      te($_POST);
      $arr=array();
      if (strlen($_POST['buch'])>0) {
        $arr[]="tbl_buecher.Titel LIKE '%".$_POST['buch']."%'";
      }
      if (strlen($_POST['jahr'])>0) {
      $arr[]="tbl_buecher.ErscheinungsJahr= " .$_POST['jahr']  ;
      }
      $sqlw="
        WHERE(
          " . implode(" AND ",$arr) . "
          )
      ";
      }else {
        $sqlw="";
      }
     ?>
     <table class="table table-striped">
       <thead>
         <tr>
           <th scope="col">Buchtitel</th>
           <th scope="col">ErscheinungsJahr</th>
           <th scope="col">Auglage</th>
           <th scope="col">ISBN</th>
           <th scope="col">Autoren</th>
         </tr>
       </thead>
       <tbody>
         <?php
     $sql = "
         SELECT tbl_buecher.*, tbl_verlage.NameVerlage FROM tbl_buecher
      LEFT JOIN tbl_verlage ON tbl_buecher.FIDVerlage = tbl_verlage.IDVerlage
      " . $sqlw . "
      ORDER BY Titel ASC
                ";
            $buecher = $conn->query($sql);
                    // output data of each row
           while($buch = $buecher->fetch_assoc()) {
             echo '
             <tr>
               <td>'. $buch['Titel'].'</td>
               <td>'. $buch['ErscheinungsJahr'].'</td>
               <td>'. $buch['Auflage'].'</td>
               <td>'. $buch['ISBN'].'</td>
              ';
               $sql="
               SELECT tbl_bucher_autor.* , tbl_autor.* FROM tbl_bucher_autor
               INNER JOIN tbl_autor oN tbl_bucher_autor.FIDAutor= tbl_autor.IDAutor
               WHERE(
                 tbl_bucher_autor.FIDBucher=". $buch['IDBucher']."
                 )
               ";
               $autoren = $conn->query($sql) or die("Fehler in query:" . $conn->error);
               while($autor = $autoren->fetch_assoc()) {
                 echo '
             <td>'. $autor['Vorname'] .   $autor['Nachname'].'</td>
                 ';
              }
             echo "</tr>";
           }
          ?>
       </tbody>
     </table>
    </body>
 </html>
