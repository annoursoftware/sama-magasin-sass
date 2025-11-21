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
                    <div class="col-sm-9">
                        <div class="form-group">
                          <label for="client">Client</label>
                          <input type="text" class="form-control rounded-0" name="client" id="client" required placeholder="Le client" />
                        </div>
                    </div>
                    
                    <div class="col-sm-3">
                        <div class="form-group">
                          <label for="type">Type</label>
                          <select class="custom-select rounded-0" id="type" name="type" required>
                            <option value="">*** Choix ***</option>
                            <option value="p">Physique</option>
                            <option value="e">Entreprise</option>
                          </select>
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                      <div class="form-group">
                          <label for="telephone">Telephone</label>
                          <input type="text" class="form-control rounded-0" name="telephone" id="telephone" placeholder="N° telephone" />
                        </div>
                    </div>
                      
                    <div class="col-sm-8">
                      <div class="form-group">
                          <label for="email">Email</label>
                          <input type="text" class="form-control rounded-0" name="email" id="email" placeholder="Email" />
                        </div>
                    </div>
                    
                    {{-- <div class="col-sm-4">
                        <div class="form-group">
                          <label for="boutique">Boutique</label>
                          <select class="custom-select rounded-0" id="boutique" name="boutique_id" required>
                            <option value="">*** Choix ***</option>
                            <option value="h">Homme</option>
                            <option value="f">Femme</option>
                          </select>
                        </div>
                    </div> --}}

                    <div class="col-sm-8">
                        <div class="form-group">
                          <label for="adresse">Adresse</label>
                          <input type="text" class="form-control rounded-0" name="adresse" id="adresse" placeholder="L'adresse" />
                        </div>
                    </div>
                        
                </div>
            </div>

            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-danger fas fa-times-circle" data-dismiss="modal"> Fermer</button>
                <button type="submit" class="btn btn-outline-primary bi bi-floppy-fill" id="nv_client"> </button>
            </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->


