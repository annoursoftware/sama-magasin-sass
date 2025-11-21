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
                          <label for="boutique">Boutique</label>
                          <input type="text" class="form-control rounded-0" name="boutique" id="boutique" required placeholder="La boutique" />
                        </div>
                    </div>
                    
                    <div class="col-sm-7">
                      <div class="form-group">
                          <label for="adresse">Adresse</label>
                          <input type="text" class="form-control rounded-0" name="adresse" id="adresse" placeholder="Adresse" />
                        </div>
                    </div>

                    <div class="col-sm-4">
                      <div class="form-group">
                          <label for="telephone">Téléphone</label>
                          <input type="text" class="form-control rounded-0" name="telephone" id="telephone" placeholder="N° telephone" />
                        </div>
                    </div>
                    
                    {{-- <div class="col-sm-4">
                        <div class="form-group">
                          <label for="email">Email</label>
                          <input type="text" class="form-control rounded-0" name="email" id="email" placeholder="Le nom de l'utilisateur" />
                        </div>
                    </div> --}}
                        
                    <div class="col-sm-5">
                      <div class="form-group">
                          <label for="responsable">Responsable</label>
                          <input type="text" class="form-control rounded-0" name="responsable" id="responsable" placeholder="Responsable" />
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                          <label for="entreprise">Entreprise</label>
                          <select class="custom-select rounded-0" id="boutique" name="boutique_id">
                            <option>*** Choix ***</option>
                            @php
                                $entreprises = DB::table('entreprises')->get();
                            @endphp
                            @foreach ($entreprises as $e)
                            <option value="{{ $e->id }}">{{ $e->entreprise }}</option>
                            @endforeach
                            {{-- <option value="f">Femme</option> --}}
                          </select>
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


