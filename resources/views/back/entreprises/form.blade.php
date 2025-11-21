<div class="modal fade" id="modal-form" data-backdrop="static">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <form id="formulaire" class="form-horizontal" method="POST" action="{{ url('api/users') }}" validate="true">
            @csrf
            @method('POST')

            <input type="hidden" name="id" id="id">
            
            <div class="row">
                <div class="col-12">
                    <blockquote class="quote-danger print-error-msg" style="display:none">
                        <ul></ul>
                    </blockquote>
                </div>
            </div>

            <div class="modal-body">
                <div class="row mt-4">
                    <div class="col-sm-5">
                        <div class="form-group">
                          <label for="entreprise">Entreprise</label>
                          <input type="text" class="form-control rounded-0" name="entreprise" id="entreprise" required placeholder="L'entreprise" />
                        </div>
                    </div>
                    
                    <div class="col-sm-3">
                      <div class="form-group">
                          <label for="telephone">Téléphone</label>
                          <input type="text" class="form-control rounded-0" name="telephone" id="telephone" placeholder="N° telephone" />
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                          <label for="email">Email</label>
                          <input type="email" class="form-control rounded-0" name="email" id="email" placeholder="Le nom de l'utilisateur" />
                        </div>
                    </div>
                        
                    <div class="col-sm-4">
                        <div class="form-group">
                          <label for="rc">Registre de commerce</label>
                          <input type="text" class="form-control rounded-0" name="rc" id="rc" placeholder="Le nom de l'utilisateur" />
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                          <label for="ninea">Ninea</label>
                          <input type="text" class="form-control rounded-0" name="ninea" id="ninea" placeholder="Le ninea de l'entreprise" />
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                          <label for="regime_juridique">Regime juridique</label>
                          <select class="custom-select rounded-0" id="regime_juridique" name="regime_juridique" required>
                            <option value="">*** Choix ***</option>
                            <option value="informel">Informel</option>
                            <option value="entreprise_individuelle">Entreprise individuelle</option>
                            <option value="gie">GIE</option>
                            <option value="sarl">SARL</option>
                            <option value="suarl">SUARL</option>
                            <option value="sa">SA</option>
                          </select>
                        </div>
                    </div>

                    <div class="col-sm-5">
                      <div class="form-group">
                          <label for="responsable">Responsable</label>
                          <input type="text" class="form-control rounded-0" name="responsable" id="responsable" placeholder="Responsable" />
                        </div>
                    </div>

                    <div class="col-sm-7">
                        <div class="form-group">
                          <label for="logo">Logo</label>
                          <input type="file" class="form-control rounded-0" name="logo" id="logo" placeholder="Le nom de l'utilisateur" />
                        </div>
                    </div>

                    <div class="col-sm-12">
                      <div class="form-group">
                          <label for="siege">Siége</label>
                          <input type="text" class="form-control rounded-0" name="siege" id="siege" placeholder="siege social" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-danger fas fa-times-circle" data-dismiss="modal"> Fermer</button>
                <button type="submit" class="btn btn-outline-primary bi bi-floppy-fill" id="insertbtn"> </button>
            </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->


