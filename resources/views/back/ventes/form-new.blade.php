<div class="modal fade" id="modal-form" data-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="vente" class="form-horizontal" method="POST" action="{{ url('api/ventes') }}" validate="true">
                @csrf
                @method('POST')
                <div class="modal-body">

                    <div class="row mt-4">
                        <div class="col-sm-12">
                            <div class="card card-maroon">
                                <div class="card-header">
                                    <h3 class="card-title">Etapes de Vente</h3>
                                </div>
                                
                                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                <input type="hidden" id="type_vente" name="type_vente" value="f">
                                    
                                <div class="row">
                                    <div class="col-12">
                                        <blockquote class="quote-danger print-error-msg" style="display:none">
                                            <ul></ul>
                                        </blockquote>
                                    </div>
                                </div>
    
                                <div class="card-body p-0">
                                    <div class="bs-stepper linear">
                                        {{-- Header --}}
                                        <div class="bs-stepper-header" role="tablist">
    
                                            <div class="step active" data-target="#detail-part">
                                                <button type="button" class="step-trigger" role="tab" aria-controls="detail-part"
                                                    id="detail-part-trigger" aria-selected="false" disabled="disabled">
                                                    <span class="bs-stepper-circle">1</span>
                                                    <span class="bs-stepper-label">Details Vente</span>
                                                </button>
                                            </div>
    
                                            <div class="line"></div>
    
                                            <div class="step" data-target="#encaissement-part">
                                                <button type="button" class="step-trigger" role="tab"
                                                    aria-controls="encaissement-part" id="encaissement-part-trigger"
                                                    aria-selected="false" disabled="disabled">
                                                    <span class="bs-stepper-circle">2</span>
                                                    <span class="bs-stepper-label">Encaissement</span>
                                                </button>
                                            </div>
                                        </div>
                                        {{-- Header --}}
    
                                        {{-- Body --}}
                                        <div class="bs-stepper-content">
    
                                            <div id="detail-part" class="content active dstepper-block" role="tabpanel"
                                                aria-labelledby="detail-part-trigger">
                                                <div class="row mt-1">
                                                    <div class="col-sm-4">
                                                        <div class="card card-maroon">
                                                            <div class="card-header">
                                                                <h3 class="card-title">Articles</h3>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-md-10 col-sm-10 col-10">
                                                                        <div class="form-group">
                                                                            <label for="pidproduit">Articles</label>
                                                                            <select name="pidproduit" id="article"
                                                                                class="custom-select rounded-0 select"
                                                                                style="width: 100%;">
                                                                                <option value="">**** Choix ****</option>
                                                                                @foreach ($articles as $p)
                                                                                    <option value="{{ $p->id }}">{{ $p->article }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <div class="col-md-1 col-sm-2 col-2">
                                                                        <div class="form-group">
                                                                            <label for="img-article"></label>
                                                                            <img id="img-article" class="img">
                                                                        </div>
                                                                        <!-- /.info-box -->
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
                                                                            <label for="pstock">Stock</label>
                                                                            <input type="text" class="form-control rounded-0" id="pstock" readonly />
                                                                        </div>
                                                                    </div>
    
                                                                    <div class="col-sm-6 col-6">
                                                                        <div class="form-group">
                                                                            <label for="pchmontant">Négociation</label>
                                                                            <input type="text" class="form-control rounded-0" id="pchmontant" />
                                                                        </div>
                                                                    </div>
    
                                                                    <div class="col-sm-6 col-6">
                                                                        <div class="form-group">
                                                                            <label for="pquantite">Quantite</label>
                                                                            <input type="number" class="form-control rounded-0"
                                                                                id="pquantite" />
                                                                        </div>
                                                                    </div>
    
                                                                    <div class="col-sm-1 col-6">
                                                                        <div class="form-group">
                                                                            <button type="button" id="btn_add"
                                                                                class="btn btn-danger btn-md">+</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
    
                                                    <div class="col-sm-8">
                                                        <div class="card card-maroon">
                                                            <div class="card-header">
                                                                <h3 class="card-title">Details Ventes</h3>
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
                                                                                        <th width="50%">Articles</th>
                                                                                        <th class="text-center" width="15%">Montant
                                                                                        </th>
                                                                                        <th class="text-center">Quantité</th>
                                                                                        <th class="text-center">Total</th>
                                                                                    </tr>
                                                                                </thead>
    
                                                                                <tbody class="text-xs">
                                                                                </tbody>
                                                                                
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
    
                                                <div class="row mt-3 d-flex align-items-center">
                                                    <div class="col-sm-12 ">
                                                        <button type="button" class="btn btn-outline-primary"
                                                            onclick="stepper.next()">Suivante <i class="bi bi-chevron-bar-right"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
    
                                            <div id="encaissement-part" class="content" role="tabpanel"
                                                aria-labelledby="encaissement-part-trigger">
                                                <div class="row mt-1">
                                                    <div class="col-sm-3 mt-0">
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <div class="card card-maroon">
                                                                    <div class="card-header">
                                                                        <h3 class="card-title">Vente</h3>
                                                                    </div>
                                                                    <div class="card-body">
                                                                        <div class="row">
                                                                            <div class="col-sm-12 col-6">
                                                                                <div class="form-group">
                                                                                    <label for="sous_total">Sous total</label>
                                                                                    <h6 id="total">S/. 0.00</h6>
                                                                                    <input type="hidden" class="form-control" name="montants" id="sous_total">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-12 col-6">
                                                                                <div class="form-group">
                                                                                    <label for="sous_total">Remise (%)</label>
                                                                                    <input type="number" class="form-control rounded-0" name="remise" id="remise_edit" placeholder="La Remise">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-12">
                                                                                <div class="form-group">
                                                                                    <label for="total">Total</label>
                                                                                    <h6 id="total_def">S/. 0.00</h6>
                                                                                    <input type="hidden" class="form-control" name="montants_apres_remise" id="total_def_val">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
    
                                                    <div class="col-sm-9 mt-0">
                                                        <div class="card card-maroon">
                                                            <div class="card-header">
                                                                <h3 class="card-title">Encaissement</h3>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-sm-3 col-12">
                                                                        <div class="form-group">
                                                                            <label for="systeme_encaissement">Systeme Paie</label>
                                                                            <select name="systeme_encaissement" id="systeme_encaissement" class="custom-select rounded-0">
                                                                                <option value="">*** Choix ***</option>
                                                                                <option value="mobile_money">Mobile money</option>
                                                                                <option value="banque">Banque</option>
                                                                                <option value="espece">Espece</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
    
                                                                    <div class="col-sm-4 col-12">
                                                                        <div class="form-group">
                                                                            <label for="mode_encaissement">Lieu de Paie</label>
                                                                            <select name="mode_encaissement" id="mode_encaissement"
                                                                                class="custom-select rounded-0">
                                                                                <option value="">**** Choix ****</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
    
                                                                    <div class="col-sm-2" id="section_bank">
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
    
                                                                    <div class="col-sm-3">
                                                                        <div class="form-group">
                                                                            <label for="ref_encaissement">Reference</label>
                                                                            <input type="text" class="form-control rounded-0"
                                                                                name="ref_encaissement" id="ref_encaissement">
                                                                        </div>
                                                                    </div>
    
                                                                    <div class="col-sm-3">
                                                                        <div class="form-group">
                                                                            <label for="encaissement">Encaissement</label>
                                                                            <input type="text" class="form-control rounded-0"
                                                                                name="encaissement" id="encaissement" />
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <div class="col-sm-3">
                                                                        <div class="form-group">
                                                                            <label for="restant">Restant</label>
                                                                            <input type="text" class="form-control rounded-0" id="restant" readonly />
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    {{-- <div class="col-sm-3">
                                                                        <div class="form-group">
                                                                            <label for="montant_donne_par_le_client">Donné</label>
                                                                            <input type="text" class="form-control rounded-0"
                                                                                name="montant_donne_par_le_client" id="montant_donne_par_le_client" />
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <div class="col-sm-3">
                                                                        <div class="form-group">
                                                                            <label for="rendu">Rendu</label>
                                                                            <input type="text" class="form-control rounded-0"
                                                                                id="rendu" readonly />
                                                                        </div>
                                                                    </div> --}}
                                                                    
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
    
                                                <div class="row mt-3">
                                                    <div class="col-sm-12 m-3">
                                                        <button type="button" class="btn btn-primary" onclick="stepper.previous()">
                                                            <i class="bi bi-chevron-bar-left"></i> Precedente
                                                        </button>
                                                        <button type="button" class="btn btn-danger disabled">Fin <i class="bi bi-ban"></i> </button>
                                                    </div>
                                                </div>
    
                                            </div>
                                        </div>
                                        {{-- Body --}}
                                    </div>
                                </div>
    
                            </div>
                        </div>
                    </div>
                    <!-- /.row -->
                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger fas fa-times-circle" data-dismiss="modal"> Fermer</button>
                    <button type="submit" class="btn btn-outline-primary bi bi-floppy-fill" id="savebtn"> Enregistrer</button>
                </div>
            </form>
            
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->