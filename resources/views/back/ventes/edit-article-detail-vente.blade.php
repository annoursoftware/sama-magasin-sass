<div class="modal fade" id="modal-form-view-article-into-dv" data-backdrop="static">
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

            <input type="hidden" {{-- value="{{ $v->id }}" --}} name="id" id="dv_id">
            
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
                        <h3 class="card-title">Detail de la vente</h3>
                      </div>
                      
                      <div class="card-body">
                        <div class="row">
                          <div class="col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                              @php
                                $articles = DB::table('articles')->get();
                              @endphp
                              <label for="article">Articles</label><br>
                              <select name="article" id="dv_article_id" class="custom-select rounded-0 select" style="width: 100%;">
                                <option value="">**** Choix ****</option>
                
                                @foreach ($articles as $a)
                                  <option value="{{ $a->id }}">{{ $a->article }}</option>
                                @endforeach
                              </select>
                            </div>
                          </div>
                        </div>
                
                        <div class="row">
                          <div class="col-sm-4 col-6">
                            <div class="form-group">
                              <label for="dv_montant">Montant</label>
                              <input type="text" class="form-control rounded-0" id="dv_montant" />
                            </div>
                          </div>
                
                          <div class="col-sm-4 col-6">
                            <div class="form-group">
                              <label for="dv_quantite">Quantite</label>
                              <input type="number" class="form-control rounded-0" id="dv_quantite" />
                            </div>
                          </div>

                          <div class="col-sm-4 col-6">
                            <div class="form-group">
                              <label for="dv_etat">Etat</label>
                              <input type="text" class="form-control rounded-0" id="dv_etat" readonly />
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
                              <label for="prix_vente_minimal">Prix vente minimal</label>
                              <input type="number" class="form-control rounded-0" id="prix_vente_minimal" readonly />
                            </div>
                          </div>
                
                          <div class="col-sm-12 col-5">
                            <div class="form-group">
                              <label for="stock">Stock</label>
                              <input type="number" class="form-control rounded-0" id="stock" readonly />
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


