<div class="modal fade" id="modal-form" data-backdrop="static">
    <div class="modal-dialog modal-md">
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
                          <label for="system_paiement">Système de Paiement</label>
                          <select class="custom-select rounded-0" id="system_paiement" name="system_paiement" required >
                            <option value="">*** Choix ***</option>
                            <option value="mobile_money">Mobile Money</option>
                            <option value="banque">Banque</option>
                            @if ($nombre_espece>0)
                            
                            @else
                              <option value="espece">Espéce</option>
                            @endif
                          </select>
                        </div>
                    </div>

                    <div class="col-sm-7">
                        <div class="form-group">
                          <label for="entite_paiement">Entité de Paiement</label>
                          <input type="text" class="form-control rounded-0" name="entite_paiement" id="entite_paiement" required placeholder="entité de paiement" />
                        </div>
                    </div>
                    
                    <div class="col-sm-12">
                        <div class="form-group">
                          <label for="image">Image</label>
                          <input type="file" class="form-control rounded-0" name="image" id="image" />
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


