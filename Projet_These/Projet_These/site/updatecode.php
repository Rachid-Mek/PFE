<?php

include '../login/config.php'; 
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../login/login.php");
}

if(isset($_POST['updatedata'])){

    $id = $_POST['update_idn'];
    $type = $_POST['typeD'];
    $nom = $_POST['NomD'];
    $prix = $_POST['PrixD'];
    $Qte = $_POST['QteD'];

    $nom = addslashes($nom);
    if($type == 'Material Pharmaceutique'){
        $milli = 0;
      }else{
        $milli = $_POST['MilligrammeD'];
      }
    
      if(isset($_FILES['my_imageD'])){
        $img_name = $_FILES['my_imageD']['name'];
        $img_size = $_FILES['my_imageD']['size'];
        $tmp_name = $_FILES['my_imageD']['tmp_name'];
        $error = $_FILES['my_imageD']['error'];
    
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
              $query = "UPDATE medicament SET Type='$type', Nom='$nom', Miligramme='$milli', Prix='$prix', Quantite='$Qte', imageURL='$new_img_name' WHERE Med_Id='$id'";
              $query_run = mysqli_query($mysqli, $query);

              if($query_run)
              {
                  header("Location:MainPage.php");
              }
              else
              {
                  echo '<script> alert("Data Not Updated"); </script>';
                  echo"<script>window.location = 'MainPage.php';</script>";
              }
            }else {
              echo"<script>alert('Vous pouvez pas ajouter un fichier de ce type')</script>";
              echo"<script>window.location = 'MainPage.php';</script>";
            }
          }
        }elseif($error === 4) {
          $PharmaID = $_SESSION['username'];
          $query= "SELECT imageURL FROM medicament where (pharma_Id='$PharmaID' AND Med_Id='$id')";
          $filtrer=$mysqli->query($query);
          if($filtrer->num_rows > 0){
            $row = $filtrer->fetch_assoc();
            $new_img_name = $row["imageURL"];
            $query = "UPDATE medicament SET Type='$type', Nom='$nom', Miligramme='$milli', Prix='$prix', Quantite='$Qte', imageURL='$new_img_name' WHERE Med_Id='$id'";
                $query_run = mysqli_query($mysqli, $query);

                if($query_run)
                {
                    header("Location:MainPage.php");
                }
                else
                {
                    echo '<script> alert("Data Not Updated"); </script>';
                    echo"<script>window.location = 'MainPage.php';</script>";
                }
            }
        }else{
          echo"<script>alert('oops! erreur')</script>";
          echo"<script>window.location = 'MainPage.php';</script>";
        }
      }else{
        $PharmaID = $_SESSION['username'];
        $query= "SELECT imageURL FROM medicament where (pharma_Id='$PharmaID' AND Med_Id='$id')";
        $filtrer=$mysqli->query($query);
        if($filtrer->num_rows > 0){
          $row = $filtrer->fetch_assoc();
          $new_img_name = $row["imageURL"];
          $query = "UPDATE medicament SET Type='$type', Nom='$nom', Miligramme='$milli', Prix='$prix', Quantite='$Qte', imageURL='$new_img_name' WHERE Med_Id='$id'";
              $query_run = mysqli_query($mysqli, $query);

              if($query_run)
              {
                  header("Location:MainPage.php");
              }
              else
              {
                  echo '<script> alert("Data Not Updated"); </script>';
                  echo"<script>window.location = 'MainPage.php';</script>";
              }
          }
      }

}

?>
