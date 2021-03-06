<?php
include '../login/config.php'; 
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../login/login.php");
}

if (isset($_POST['Submit'])){
  $Nom = $_POST['NomP'];
  $Prix = $_POST['Prix'];
  $QTE = $_POST['Qte'];
  $Type = $_POST['typeP'];
  $PharmaID = $_SESSION['username'];

  $Nom = addslashes($Nom);

  if($Type == 'Material Pharmaceutique'){
    $mili = 0;
  }else{
    $mili = $_POST['Milligramme'];
  }

  if(isset($_FILES['my_image'])){
    $img_name = $_FILES['my_image']['name'];
    $img_size = $_FILES['my_image']['size'];
    $tmp_name = $_FILES['my_image']['tmp_name'];
    $error = $_FILES['my_image']['error'];

    $query= "SELECT Nom, Miligramme FROM medicament where Nom='$Nom' AND Miligramme='$mili'";
    $result=$mysqli->query($query);
    if($result->num_rows > 0){
      echo"<script>alert('Vous avez deja insérer ce produit')</script>";
      echo "<script>window.location = 'MainPage.php';</script>";
    }
    else{ 
    if ($error === 0) {
      if ($img_size > 125000) {
        echo"<script>alert('Désolé, fichier trop grand')</script>";
        echo"<script>window.location = 'MainPage.php';</script>";
      }else {
        $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
        $img_ex_lc = strtolower($img_ex);
  
        $allowed_exs = array("jpg", "jpeg", "png"); 
  
        if (in_array($img_ex_lc, $allowed_exs)) {
          $new_img_name = uniqid("IMG-", true).'.'.$img_ex_lc;
          $img_upload_path = 'uploads/'.$new_img_name;
          move_uploaded_file($tmp_name, $img_upload_path);
  
          // Insert into Database
          $sql2 = "INSERT INTO medicament (pharma_Id, Type, Nom, Miligramme, Prix, Quantite, imageURL)
            VALUES ('$PharmaID ', '$Type', '$Nom', '$mili', '$Prix', '$QTE', '$new_img_name')";
          
          $result2 = $mysqli->query($sql2);
          if ($result2){
            $Nom = "";
            $Prix = "";
            $QTE = "";
            $Type = "";
            $new_img_name = "";
            header("Location: MainPage.php");
          }else{
            echo"<script>alert('oops! erreur')</script>";
            echo"<script>window.location = 'MainPage.php';</script>";
          }
        }else {
          echo"<script>alert('Vous pouvez pas ajouter un fichier de ce type')</script>";
          echo"<script>window.location = 'MainPage.php';</script>";
        }
      }
    }elseif($error === 4) {
      $new_img_name = "IMG-noimage.jpg";
      $sql2 = "INSERT INTO medicament (pharma_Id, Type, Nom, Miligramme, Prix, Quantite, imageURL)
              VALUES ('$PharmaID ', '$Type', '$Nom', '$mili', '$Prix', '$QTE', '$new_img_name')";
      $result2 = $mysqli->query($sql2);
      if ($result2){
        $Nom = "";
        $Prix = "";
        $QTE = "";
        $Type = "";
        header("Location: MainPage.php");
      }else{
        echo"<script>alert('oops! erreur')</script>";
        echo"<script>window.location = 'MainPage.php';</script>";
      }
    }else{
      echo"<script>alert('oops! erreur')</script>";
      echo"<script>window.location = 'MainPage.php';</script>";
    }
  }
 } 
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <style>
      <?php
        include 'mystyle.css'
      ?>
    </style>
    <title>Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  </head>
  <body>

   <?php 
      include './pharmInfo.php'
   ?>
    <nav class="navBar">
      <div class="container">
        <ul class="flex-bar">
         <li><div data-text="Pharmacie..." id="pharmName">Pharmacie...</div></li>    
         <div class="end">
         <li><button type="button" class="btn btn-primary editInfo" data-toggle="modal" data-target="#editModal" id="navBtn">Ma Pharmacie</button></li>
         <li><a href="../login/logout.php">Deconnecter</a></li> 
         </div>
        </ul>
      </div>
    </nav>
    
  <div class="flexTable">
    <div class="myWebSite">
      <div class="formulaire">
        <div class="titre"><h2>Formulaire</h2></div>

        <form action="#" method="post" enctype='multipart/form-data'>

          <div class="radioInput">
            <label for="type" class='labelname'> Type de Produit:</label>

            <label class="radiochoice"> Médicament 
              <input type="radio" id="type" name="typeP" value="Medicament" checked="checked"/>
              <span class="checkmark"></span>
            </label>

            <label class="radiochoice"> Matérial Pharmaceutique
              <input type="radio" name="typeP" id="type" value="Material Pharmaceutique"/>
              <span class="checkmark"></span>
            </label>
          </div>

          <div class="dataInput">
            <label for="NomP">Nom de Produit:</label>
            <input
              type="text"
              name="NomP"
              id="Nom"
              placeholder="Tapez le nom"
              required
            />
          </div>

          <div class="dataInput">
            <label for="mili"> Millgramme :</label>
            <input
              type="number"
              name="Milligramme"
              id="mili"
              placeholder="Tapez les milligrammes"
              required  
            />
          </div>

          <div class="dataInput">
            <label for="Prix"> Prix:</label>
            <input
              type="number"
              name="Prix"
              id="Prix"
              placeholder="Tapez le prix"
              required     
            />
          </div>

          <div class="dataInput">
            <label for="QTE"> Quantité:</label>
            <input
              type="number"
              name="Qte"
              id="Qte"
              placeholder="Tapez la Quantité"
              required     
            />
          </div>

          <div class="imageInput">
            <label for="image">Choisir une image</label>
            <input
              type="file" 
              name="my_image"
              id="image"
            />
          </div>

          <div class="dataInput">
            <input type="submit" value="Ajouter Le Produit" id="myBtn" name="Submit" />
          </div>

        </form>
      </div>
    </div>
  
<div class="MedicaleTable">
    <div class="Mytable">
        <form action="" method="post">   
      <div class="searching">

        <?php $search = (isset($_POST['Rechercher'])) ? htmlentities($_POST['Rechercher']) : ''; ?>

    <input class="form-control mr-sm-2" type="search" placeholder="rechercher par nom" name="Rechercher" id="searchBox" value="<?= $search ?>"/>
    <input class="btn btn-outline-success my-2 my-sm-0" type="submit" name="searchsub" value="rechercher" />
       </div>
         </form>
         <table class="Table">
         
            <?php    
          
            $PharmaID = $_SESSION['username'];

          if (isset($_POST['searchsub'])){
           $valueToSearch = $_POST['Rechercher'];
           $valueToSearch = addslashes($valueToSearch);
           if($valueToSearch==""){
            $query= "SELECT Med_Id, Type, Nom, Miligramme, Prix, Quantite, imageURL FROM medicament where pharma_Id='$PharmaID'";
            $var1 = 1;
            $search_result=filtrerTable($query, $var1);
           }
           else{
           $query ="SELECT Med_Id, Type, Nom, Miligramme, Prix, Quantite, imageURL FROM medicament where (Nom LIKE '%$valueToSearch%' and pharma_Id='$PharmaID')";
           $var1 = 0;
           $search_result=filtrerTable($query, $var1);
           }
         }
            else{
               $query= "SELECT Med_Id, Type, Nom, Miligramme, Prix, Quantite, imageURL FROM medicament where pharma_Id='$PharmaID'";
               $var1 = 1;
               $search_result=filtrerTable($query, $var1);
               
            }
     
            function filtrerTable($query, $var1)
            { include '../login/config.php';
              
              $filtrer=$mysqli->query($query);
              if($filtrer->num_rows > 0){
               echo "   
               <thead>
               <tr>
                 <th>Type</th>
                 <th>Nom</th>
                 <th>Milligramme</th>
                 <th>prix</th>
                 <th>Quantité</th>
                 <th>Image</th>
                 <th>supprimer</th>
                 <th>modifier</th>
               </tr>
             </thead>";
                while($row = $filtrer->fetch_assoc()){
                  echo "<tr>
                  <td>". $row["Type"]. "</td>
                  <td>". $row["Nom"]. "</td>
                  <td>". $row["Miligramme"]."</td>
                  <td>". $row["Prix"]."</td>
                  <td><p class='statusdispo'>". $row["Quantite"]."</p></td>
                  <td class='imageshow'> <img src='uploads/". $row["imageURL"]."'></td>
                  <td class='centerbutton1'><a href='delete.php?id=". $row["Med_Id"]."' id='btn'><ion-icon name=trash-outline></ion-icon></a></td>
                  <td class='centerbutton1'> <button type='button' id=". $row["Med_Id"]." class='btn btn-success editbtn'> <ion-icon name=create-sharp></ion-icon> </button></td>
                  </tr>";
                }
                echo "</table>";
              }elseif($var1 == 0){
                echo "
                <div class=mainresult>
                <div class=resultat>
                  le nom n'exist pas !
                </div>
                </div>";
              } else{
                echo "
                <div class=mainresult>
                <div class=resultat>
                  Il ne y'a Aucun medicament dans la base de donnée 
                </div>
                </div>";
              }
              return $filtrer;
            }
            ?>
          </table>
          
        </div>
      </div>
  
  </div>
      
    <?php include './edit.php' ?>

    <script src="./index.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    
    <script>
        $(document).ready(function () {

            $('.editbtn').on('click', function () {

                $('#editmodal').modal('show');

                $tr = $(this).closest('tr');

                var data = $tr.children("td").map(function () {
                    return $(this).text();
                }).get();

                console.log(data);
                if (data[0] == "Medicament"){ 
                  $("#typeP1").prop("checked", true);
                  $('#miliP').val(data[2]);
                  $('#miliP').prop( "disabled", false);
                }
                else{
                  $("#typeP2").prop("checked", true);
                  $('#miliP').val(0);
                  $('#miliP').prop( "disabled", true);
                }
                $('#NomP').val(data[1]);
                $('#PrixP').val(data[3]);
                $('#QteP').val(data[4]);
                $('#update_id').val($(this).attr('id'));
                
                var arr2 = document.querySelectorAll('input[name="typeD"]');
                var field2 = document.getElementById("miliP");
                  arr2.forEach((radio) => {
                  radio.addEventListener("change", () => {
                    if (radio.value == "Material Pharmaceutique") {
                      field2.disabled = true;
                      field2.style.backgroundColor = "#ccc";
                      $('#miliP').val(0);
                    } else {
                      field2.disabled = false;
                      field2.style.background = "transparent";
                      $('#miliP').val(data[2]);
                    }
                  });
                });
            });
        });
    </script>
    <script>
      var Elements = document.getElementsByClassName('statusdispo');
      for (let i=0; i< Elements.length; i++){
          if (Elements[i].innerHTML != "0"){
            Elements[i].style.color = "#388e3c";
            Elements[i].style.backgroundColor= "#c8e6c9";
          }
          else{
            Elements[i].style.color = "#c62828";
            Elements[i].style.backgroundColor= "#ffcdd2";
          }
      }
    </script> 
  </body>
</html>
