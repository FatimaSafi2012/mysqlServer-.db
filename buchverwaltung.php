<?php

/*
Erstellen Sie einerseits ein Redaktionssystem für einen Administrator,
 welches nur über einen Login erreichbar sein darf (die Administratoren sollen in einer eigenen Tabelle abgespeichert werden).
 Hierin soll ein Administrator Verlage, Autoren und Bücher anlegen/ändern und löschen können.

*/

include("includes/db.php");
require("includes/config.inc.php");
$_SESSION['logged']=0;
$msg="";
if (count($_POST)>0) {
  te($_POST);
  $sql="
  SELECT * FROM tbl_bib_user
  WHERE(
    Email='" . $conn->real_escape_string($_POST['email']) ."' AND
    Passwort='" . $conn->real_escape_string($_POST['password']). "'
    )
  ";
  $users = $conn->query($sql);

if ($users->num_rows ==1) {
  // output data of each row
  while($user = $users->fetch_assoc()) {
$_SESSION['logged']=1;
header("location: rs.php");

}
}else {
  $msg='<p class="error"> Leider waren Ihre Logindaten nicht korrekt_ bitte versuchen sie erneut</p>';
}

}
 ?>
 <!DOCTYPE html>
 <html lang="de">
   <head>
     <meta charset="utf-8">
     <!-- CSS only -->
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
     <title></title>
     <style media="screen">
     body{
       box-sizing: border-box;
       font-size: 24px;
     }
     .container  {
      margin: auto;
      width: 50%;
      border: 3px solid gray;
      padding: 10px;
}
h2{
   text-align: center;
}

     </style>
   </head>
   <body>
    <?php echo $msg; ?>
     <div class="container">
       <form method="post">
           <h2>Login</h2>
           <div class="mb-3">
             <label for="email" class="form-label">Email address</label>
             <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp">
           </div>
           <div class="mb-3">
             <label for="password" class="form-label">Password</label>
             <input type="password" class="form-control" id="password" name="password">
           </div>
           <button type="submit" class="form-control">einloggen</button>
         </form>
     </div>
    </body>
 </html>
