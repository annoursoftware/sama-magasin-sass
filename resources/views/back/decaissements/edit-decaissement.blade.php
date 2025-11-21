<div class="modal fade" id="modal-form-view-detail-decaissement" data-backdrop="static">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title-show"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <form id="vente" class="form-horizontal" method="POST" action="{{ url('api/users') }}" validate="true">
            @csrf
            @method('POST')

            <input type="hidden" name="id" id="dv_id">
            
            <div class="row">
                <div class="col-12">
                    <blockquote class="quote-danger print-error-msg" style="display:none">
                        <ul></ul>
                    </blockquote>
                </div>
            </div>

            <div class="modal-body">
                <div class="row mt-3">
                  <div class="col-sm-8 col-12">
                    <div class="card card-maroon">
                      <div class="card-header">
                        <h3 class="card-title">Details decaissement</h3>
                      </div>
                      
                      <div class="card-body">
                        <div class="row">
                          <div class="col-md-5 col-sm-12 col-12">
                            <div class="form-group">
                              <label for="dv_mode_decaissement">Mode décaissement</label><br>
                              <input type="text" class="form-control rounded-0" id="dv_mode_decaissement" readonly />
                            </div>
                          </div>

                          <div class="col-md-7 col-sm-12 col-12">
                            <div class="form-group">
                              <label for="dv_lieu_decaissement">Lieu décaissement</label>
                              <input type="text" class="form-control rounded-0" id="dv_lieu_decaissement" readonly />
                            </div>
                          </div>
                        </div>
                
                        <div class="row">
                          <div class="col-sm-6 col-6">
                            <div class="form-group">
                              <label for="dv_ref_decaissement">Référence décaissement <code data-toggle="tooltip" title="modifiez le champ et quittez le afin de le modifier définitivement !"><strong><i class="bi bi-info-circle"></i></strong></code></label>
                              <input type="text" class="form-control rounded-0" id="dv_ref_decaissement" />
                            </div>
                          </div>

                          <div class="col-sm-6 col-6">
                            <div class="form-group">
                              <label for="dv_montant">Montant décaissement <code data-toggle="tooltip" title="modifiez le champ et quittez le afin de le modifier définitivement !"><strong><i class="bi bi-info-circle"></i></strong></code></label>
                              <input type="text" class="form-control rounded-0" id="dv_montant" />
                            </div>
                          </div>
                          
                          <div class="col-sm-6 col-6">
                            <div class="form-group">
                              <label for="dv_created_at">Date Enregistrement</label>
                              <input type="datetime-local" class="form-control rounded-0" id="dv_created_at" readonly />
                            </div>
                          </div>

                          <div class="col-sm-4 col-6">
                            <div class="form-group">
                              <label for="dv_etat">Etat</label>
                              <select name="etat" id="dv_etat" class="custom-select rounded-0">
                                <option value="">*** Choix ***</option>
                                <option value="1">Actif</option>
                                <option value="0">Annulée</option>
                              </select>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                
                  <div class="col-sm-4 col-12">
                    <div class="card card-maroon">
                      <div class="card-header">
                        <h3 class="card-title">Informations Article</h3>
                      </div>
                      
                      <div class="card-body">
                
                        <div class="row">
                          <div class="col-sm-12 col-7">
                            <div class="form-group">
                              <label for="dv_caissier">Caissier</label>
                              <input type="text" class="form-control rounded-0" id="dv_caissier" readonly />
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-danger fas fa-times-circle" data-dismiss="modal"> Fermer</button>
                <button type="submit" class="btn btn-outline-primary bi bi-floppy-fill" id="savebtn"> </button>
            </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->


