<div class="modal fade" id="modal-form" data-backdrop="static">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <form id="vente" class="form-horizontal" method="POST" action="{{ url('api/users') }}" validate="true">
            @csrf
            @method('POST')

            <input type="hidden" value="{{ $prestation->id }}" name="id" id="id">
            
            <div class="row">
                <div class="col-12">
                    <blockquote class="quote-danger print-error-msg" style="display:none">
                        <ul></ul>
                    </blockquote>
                </div>
            </div>

            <div class="modal-body">
                <div class="row mt-3">
                  <div class="col-sm-4">
                    <div class="card card-maroon">
                      <div class="card-header">
                        <h3 class="card-title">Activités</h3>
                      </div>
                      <div class="card-body">
                        <div class="row">
                          <div class="col-md-10 col-sm-12 col-12">
                            <div class="form-group">
                              <label for="pidproduit">Activité</label><br>
                              <select name="pidproduit" id="article" class="custom-select rounded-0 select" style="width: 100%;">
                                <option value="">**** Choix ****</option>
                                @php
                                  $activites = DB::table('activites')->get();
                                @endphp
                
                                @foreach ($activites as $a)
                                  <option value="{{ $a->id }}">{{ $a->activite }}</option>
                                @endforeach
                              </select>
                            </div>
                          </div>

                        </div>
                
                        <div class="row">
                          <div class="col-sm-6 col-6">
                            <div class="form-group">
                              <label for="pmontant">Montant</label>
                              <input type="text" class="form-control rounded-0" id="pmontant" readonly />
                            </div>
                          </div>
                
                          <div class="col-sm-6 col-6">
                            <div class="form-group">
                              <label for="pchmontant">Négociation</label>
                              <input type="text" class="form-control rounded-0" id="pchmontant" />
                            </div>
                          </div>
                
                          <div class="col-sm-1 col-6">
                            <div class="form-group">
                              <button type="button" id="btn_add" class="btn btn-danger btn-md">+</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                
                  <div class="col-sm-8">
                    <div class="card card-maroon">
                      <div class="card-header">
                        <h3 class="card-title">Tâches</h3>
                      </div>
                      <div class="card-body">
                        <div class="row">
                          <div class="col-sm-12">
                            <div class="table-responsive">
                              <table class="table table-striped table-bordered table-condensed table-hover mt-1" id="details">
                                <thead style="background-color:rgb(243, 64, 118)">
                                  <tr class="text-white text-sm">
                                    <th class="text-center" width="3%">Options
                                    </th>
                                    <th width="50%">Activité</th>
                                    <th class="text-center" width="15%">Montant</th>
                                    <th class="text-center">Total</th>
                                  </tr>
                                </thead>
                
                                </tbody class="text-xs">
                                </tbody>
                
                              </table>
                            </div>
                          </div>
                        </div>
                
                        <div class="row d-flex">
                          <div class="col-sm-6 ml-auto">
                            <div class="table-responsive">
                              <table class="table table-striped table-bordered table-condensed table-hover mt-0">
                                <tfooter>
                                  <tr style="background-color:rgb(243, 64, 118)" class="text-white text-sm">
                                    <th class="text-center" colspan="1">Sous total</th>
                                    <th class="text-center" id="total"></th>
                                    <input type="hidden" class="form-control" name="montants" id="sous_total">
                                  </tr>
                                  {{-- <tr class="text-black text-sm">
                                    <th class="text-center" colspan="2">
                                      <input type="number" class="form-control" name="remise" id="remise"
                                        placeholder="La Remise en %" />
                                    </th>
                                  </tr>
                                  <tr style="background-color:rgb(243, 64, 118)" class="text-white text-sm">
                                    <th class="text-center" colspan="1">Montant Remise</th>
                                    <th class="text-center" id="montant_remise"></th>
                                  </tr>
                                  <tr style="background-color:rgb(243, 64, 118)" class="text-white text-sm">
                                    <th class="text-center" colspan="1">Total après remise</th>
                                    <th class="text-center" id="total_def"></th>
                                    <input type="hidden" class="form-control" name="montants_apres_remise" id="total_def_val">
                                  </tr> --}}
                                </tfooter>
                              </table>
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


