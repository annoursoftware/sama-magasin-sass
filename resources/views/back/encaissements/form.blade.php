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

            <input type="hidden" value="{{ $encaissement->id }}" name="encaissement_id" id="encaissement_id">
            
            <div class="row">
                <div class="col-12">
                    <blockquote class="quote-danger print-error-msg" style="display:none">
                        <ul></ul>
                    </blockquote>
                </div>
            </div>

            <div class="modal-body">
                <div class="row mt-4">
                    <div class="col-sm-5 col-12">
                        <div class="form-group">
                            <label for="systeme_encaissement">Systeme Paie</label>
                            <select name="systeme_encaissement"
                                id="systeme_encaissement" class="custom-select rounded-0">
                                <option value="">*** Choix ***</option>
                                <option value="mobile_money">Mobile money</option>
                                <option value="banque">Banque</option>
                                <option value="espece">Espece</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-7 col-12">
                        <div class="form-group">
                            <label for="mode_encaissement">Mode</label>
                            <select name="mode_encaissement" id="mode_encaissement"
                                class="custom-select rounded-0">
                                <option value="">**** Choix ****</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-4" id="section_bank">
                        <div class="form-group">
                            <label for="moyen_bancaire">Moyen Bancaire</label>
                            <select name="moyen_bancaire" id="moyen_bancaire"
                                class="custom-select rounded-0">
                                <option value="">CHOIX</option>
                                <option>Cheque</option>
                                <option>Virement</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-8">
                        <div class="form-group">
                            <label for="ref_encaissement">Reference</label>
                            <input type="text" class="form-control rounded-0"
                                name="ref_encaissement" id="ref_encaissement">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="encaissement">Encaissement</label>
                            <input type="text" class="form-control rounded-0"
                                name="encaissement" id="encaissement" />
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="production">Production</label>
                            <input type="text" class="form-control rounded-0"
                                id="production" value="{{ $production }}" readonly />
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="restant">Restant</label>
                            <input type="text" class="form-control rounded-0"
                                id="restant" value="{{ $production-$encaissements->sum('montant') }}" readonly />
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-danger fas fa-times-circle" data-dismiss="modal"> Fermer</button>
                @if ($production-$encaissements->sum('montant')==0)
                    
                @else
                  <button type="submit" class="btn btn-outline-primary bi bi-floppy-fill" id="insertbtn"> </button>
                @endif
            </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->


