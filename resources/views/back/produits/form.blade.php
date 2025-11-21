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
                          <label for="produit">Produit</label>
                          <input type="text" class="form-control rounded-0" name="produit" id="produit" required placeholder="Le produit" />
                        </div>
                    </div>
                    
                    <div class="col-sm-3">
                      <div class="form-group">
                          <label for="prix_vente">Prix vente minimal <code data-toggle="tooltip" title="Le prix de vente minimal après marchandage en XOF !"><strong><i class="bi bi-info-circle"></i></strong></code></label>
                          <input type="number" class="form-control rounded-0" name="prix_vente_minimal" id="prix_vente" placeholder="Prix de vente" />
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                          <label for="localisation">Localisation <code data-toggle="tooltip" title="Emplacement de l'article !"><strong><i class="bi bi-info-circle"></i></strong></code></label>
                          <input type="text" class="form-control rounded-0" name="localisation" id="localisation" placeholder="La localisation" />
                        </div>
                    </div>
                        
                    @php
                      $categories = DB::table('categories')->get();
                      $boutiques = DB::table('boutiques')->get();
                    @endphp
                    
                    <div class="col-sm-6">
                        <div class="form-group">
                          <label for="categorie">Categories</label>
                          <select class="custom-select rounded-0" id="categorie" name="categorie_id" required>
                            <option value="">*** Choix ***</option>
                            @foreach ($categories as $c)
                            <option value="{{ $c->id }}">{{ $c->categorie }}</option>
                            @endforeach
                          </select>
                        </div>
                    </div>
                    
                    <div class="col-sm-6">
                        <div class="form-group">
                          <label for="boutique">Boutique</label>
                          <select class="custom-select rounded-0" id="boutique" name="boutique_id" required>
                            <option value="">*** Choix ***</option>
                            @foreach ($boutiques as $b)
                            <option value="{{ $b->id }}">{{ $b->boutique }}</option>
                            @endforeach
                          </select>
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


