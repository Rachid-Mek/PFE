<?php include '../login/config.php'?>
<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modifier les informations:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

      <?php
      include '../login/config.php';
      $PharmaID = $_SESSION['username'];

        $sql= "SELECT Name, Contact_Number1, Contact_Number2, Location, Email FROM pharma_info where Id='$PharmaID'";
        $result = $mysqli->query($sql);         
          if($result->num_rows > 0){
            $row = $result->fetch_assoc();
              $pharmname = $row["Name"];
              $pharmPhone1 = $row["Contact_Number1"];
              $pharmPhone2 = $row["Contact_Number2"];
              if ($pharmPhone2 == "0000000000"){
                $pharmPhone2 = "";
              }
              $pharmLocation = $row["Location"];
              $pharmEmail = $row["Email"];
            }
      ?>

  <form action="informations.php" method="POST">
        <div class="form-group">
           <label for="nameInput">Nom de pharmacie:</label>
           <input type="text" name="pharmName" class="form-control" id="nameInput" placeholder="Tapez Le Nom" required value="<?= $pharmname ?>">
        </div>
     <div class="form-group">
          <label for="InputNumber1">Numero de telephone 1:</label>
          <input type="Number" name="pharmNum1" class="form-control" id="InputNumber1" placeholder="Tapez Le Numero de Telephone 1" required value="<?= $pharmPhone1 ?>">
    </div>
    <div class="form-group">
          <label for="InputNumber2">Numero de telephone 2:</label>
          <input type="Number" name="pharmNum2" class="form-control" id="InputNumber2" placeholder="Tapez Le Numero de Telephone 2 (optionnel)" value="<?= $pharmPhone2 ?>">
    </div>
    <div class="form-group">
          <label for="Adresse">Adresse:</label>
          <input type="text" name="pharmAdr" class="form-control" id="Adresse" placeholder="Tapez l'Adresse" required value="<?= $pharmLocation ?>">
    </div>
    <div class="form-group">
    <label for="Email">Email:</label>
    <input type="email" name="pharmEmail" class="form-control" id="Email" placeholder="Tapez l'Email" required value="<?= $pharmEmail ?>">
  </div>
 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
        <button type="submit" name="EditInfo" class="btn btn-primary">Sauvgarder</button>
      </div>
  </form>
    </div>
  </div>
</div>