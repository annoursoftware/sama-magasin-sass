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
            
            @php
                $boutiques = DB::table('boutiques')->get();
                $beneficiaires = DB::table('beneficiaires')->get();
            @endphp

            <div class="modal-body">
                <div class="row mt-4">
                    <div class="col-sm-12">
                        <div class="form-group">
                          <label for="libelle">Libellé <span class="text-danger">*</span></label>
                          <input type="text" class="form-control rounded-0" name="libelle" id="libelle" required placeholder="Le libelle de la dépense" />
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                          <label for="numero_facture_benef">N° Facture</label>
                          <input type="text" class="form-control rounded-0" name="numero_facture_benef" id="numero_facture_benef" placeholder="N° facture beneficiaire" />
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                      <div class="form-group">
                          <label for="montant">montant (XOF) <span class="text-danger">*</span></label>
                          <input type="number" class="form-control rounded-0" name="montant" id="montant" required placeholder="Montant facture" />
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                          <label for="type">Type dépense</label>
                          <select class="custom-select rounded-0" id="type" name="type">
                            <option value="">*** Choix ***</option>
                            <option value="dir">Directe</option>
                            <option value="dif">Différé</option>
                          </select>
                        </div>
                    </div>
                    
                    <div class="col-sm-3">
                      <div class="form-group">
                          <label for="effet">Effet</label>
                          <input type="date" class="form-control rounded-0" name="effet" id="effet" />
                        </div>
                    </div>
                    
                    <div class="col-sm-3">
                      <div class="form-group">
                          <label for="limite">Limite</label>
                          <input type="date" class="form-control rounded-0" name="limite" id="limite" />
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                          <label for="boutique">Boutique</label>
                          <select class="custom-select rounded-0" id="boutique" name="boutique_id">
                            <option value="">*** Choix ***</option>
                            @foreach ($boutiques as $b)
                            <option value="{{ $b->id }}">{{ $b->boutique }}</option>
                            @endforeach
                          </select>
                        </div>
                    </div>
                          
                    <div class="col-sm-4">
                        <div class="form-group">
                          <label for="beneficiaire">Bénéficiaire</label>
                          <select class="custom-select rounded-0" id="beneficiaire" name="beneficiaire_id">
                            <option value="">*** Choix ***</option>
                            @foreach ($beneficiaires as $benef)
                            <option value="{{ $benef->id }}">{{ $benef->beneficiaire }}</option>
                            @endforeach
                          </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-danger fas fa-times-circle" data-dismiss="modal"> Fermer</button>
                <button type="submit" class="btn btn-outline-primary bi bi-floppy-fill" id="nv_depense"> </button>
            </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->


