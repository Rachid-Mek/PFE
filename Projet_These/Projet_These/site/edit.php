<?php include '../login/config.php';
?>

 <!-- EDIT POP UP FORM (Bootstrap MODAL) -->
 <div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Modifier Les Informations </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="updatecode.php" method="POST" enctype='multipart/form-data'>

                    <div class="modal-body">

                        <input type="hidden" name="update_idn" id="update_id">

                        <div class="form-group">
                          <div class="radioInput">
                            <label for="type" class='labelname'> Type de Produit:</label>

                            <label class="radiochoice"> Médicament 
                              <input type="radio" id="typeP1" name="typeD" value="Medicament" class="form-control"/>
                              <span class="checkmark"></span>
                            </label>

                            <label class="radiochoice"> Matérial Pharmaceutique
                              <input type="radio" name="typeD" id="typeP2" value="Material Pharmaceutique" class="form-control"/>
                              <span class="checkmark"></span>
                            </label>
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="NomP">Nom de Produit:</label>
                            <input
                              type="text"
                              name="NomD"
                              id="NomP"
                              placeholder="Tapez le nom"
                              class="form-control"
                              required
                            />
                        </div>

                        <div class="form-group">
                          <label for="mili"> Millgramme :</label>
                            <input
                              type="number"
                              name="MilligrammeD"
                              id="miliP"
                              placeholder="Tapez les milligrammes"
                              class="form-control"
                              required  
                            />
                        </div>

                        <div class="form-group">
                          <label for="Prix"> Prix:</label>
                            <input
                              type="number"
                              name="PrixD"
                              id="PrixP"
                              placeholder="Tapez le prix"
                              class="form-control"
                              required     
                            />
                        </div>

                        <div class="form-group">
                          <label for="QTE"> Quantité:</label>
                          <input
                            type="number"
                            name="QteD"
                            id="QteP"
                            placeholder="Tapez la Quantité"
                            class="form-control"
                            required     
                          />
                        </div>

                        <div class="imageInput">
                        <label for="imageP">Modifier l'Image</label>
                        <input
                          type="file" 
                          name="my_imageD"
                          id="imageP"
                        />
                      </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                        <button type="submit" name="updatedata" class="btn btn-primary">Modifier</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
