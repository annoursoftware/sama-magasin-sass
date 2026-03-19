<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    {{-- <link rel="stylesheet" href="{{ asset('bootstrap.min.css') }}"> --}}
    <link rel="stylesheet" href="bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Josefin+Slab" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        #test {
            font-size:x-small;
        }
        #test2 {
            font-size:xx-small;
        }

        .margin {
            margin-top: 5px;
        }

        hr {
            border: 1px outset #f7f7f7;
            margin: 12px;
        }

        .footer {
            position: absolute;
            bottom: -19px;
            width: 100%;
            height: 50px;
            color:#4b646f;
        }
        body{
            text-align: justify;
            text-justify: inter-word;
            font-family: "Josefin Slab"; font-size: 24px; font-style: normal; font-variant: normal; font-weight: 700; line-height: 26.4px;
        }
        h3 {
            font-family: "Josefin Slab"; font-size: 14px; font-style: normal; font-variant: normal; font-weight: 700; line-height: 15.4px;
        }
        p {
             font-family: "Josefin Slab"; font-size: 14px; font-style: normal; font-variant: normal; font-weight: 400; line-height: 20px;
        }
        blockquote
        {
            font-family: "Josefin Slab"; font-size: 21px; font-style: normal; font-variant: normal; font-weight: 400; line-height: 30px;
        }
        pre {
            font-family: "Josefin Slab"; font-size: 13px; font-style: normal; font-variant: normal; font-weight: 400; line-height: 18.5714px;
        }

        li {
            font-family: "Josefin Slab"; font-size: 13px; font-style: normal; font-variant: normal; font-weight: 400; line-height: 18.5714px;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
    <title>Recouvrements | Créances</title>
</head>
<body>
    <!-- Exemplaire Compagnie -->
    <div class="container" style="margin-top: 5px">
        <div class="row">
            <div class="col-xs-2 pull-left">
                <h2>
                    {{-- <img src="{{ asset('upload/logo/'.$parametrage->logo) }}" width="150px" height="60px" alt="{{ asset('logo.jpg') }}"> --}}
                </h2>
            </div>
            {{-- <div class="col-xs-5 pull-right">
                <strong class="text-uppercase">
                    <h5 id="test2">
                        <u>Client</u> : <strong>gdhghdg</strong>
                    </h5>
                    <h5 id="test2">
                        <u>Telephone</u> : <strong>uiiutbcbn</strong>
                    </h5>
                    <h5 id="test2">
                        <u>Adresse</u> :  <strong>uiybncnpouo</strong>
                    </h5>
                </strong>
            </div> --}}
        </div>

        <div class="row" id="test5" style="margin-top: 10px">
            <div class="col-xs-12 text-center">
                <h5>
                    <strong class="text-uppercase">
                        Créances
                    </strong>
                </h5>
            </div>
        </div>

        <div class="row" id="" style="margin-top: 30px">
            <div class="col-xs-12">
                @if (count($resultat)==0)
                    <div class="alert alert-danger text-center" role="alert"><h4>Aucun Impayé à cette periode</h4></div>
                @else
                    <table class="table table-bordered">
                        <thead id="test" style="background-color: #D3D3D3">
                            <tr>
                                <th class="text-center">#</th>
                                <th>Contrat</th>
                                <th>Client</th>
                                {{-- <th>Telephone</th> --}}
                                {{-- <th>Voiture</th>
                                <th>Plaque</th> --}}
                                <th class="text-center">Production</th>
                                <th class="text-center">Encaissements</th>
                                <th class="text-center">Restant</th>

                            </tr>
                        </thead>

                        <tbody id="test2">
                            <?php $i = 0 ?>
                            @foreach($resultat as $r)
                            <?php $i++ ?>
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>{{ $r->num_contrat }}</td>
                                    <td>{{ $r->client }}</td>
                                    {{-- <td>{{ $r->telephone }}</td> --}}
                                    {{-- <td>{{ $r->voiture }}</td>
                                    <td>{{ $r->immatriculation }}</td> --}}
                                    <td class="text-center">{{ number_format(($r->montant) , 0, ",",".")}} FCFA</td>
                                    <td class="text-center">{{ number_format(($r->montant_encaisse) , 0, ",",".")}} FCFA</td>
                                    <td class="text-center">{{ number_format(($r->montant_restant_a_encaisser) , 0, ",",".")}} FCFA</td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                @endif


            </div>

        </div>

        <div class="row" id="test" style="margin-top: 7px">
            <div class="col-xs-5 pull-left">

                <table id="" class="table table-bordered">

                    <tbody>
                        <tr>
                            <td class="">Production</td>
                            <td class="text-center">{{ number_format(($facture) , 0, ",",".")}} FCFA</td>
                        </tr>
                        <tr>
                            <td class="">Encaissements</td>
                            <td class="text-center">{{ number_format(($encaissement) , 0, ",",".")}} FCFA</td>
                        </tr>
                        <tr>
                            <td class="">Impayés</td>
                            <td class="text-center">{{ number_format(($restant) , 0, ",",".")}} FCFA</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>


        <div class="row" id="test" style="margin-top: 15px">
            <div class="col-xs-3 pull-left">
                <h5>
                    <strong>
                        Fait à Dakar, le {{ \Carbon\Carbon::parse(now())->format('d/m/Y') }}
                    </strong>
                </h5>
            </div>
        </div>

        {{-- <div class="row" id="test" style="margin-top: 35px">
            <div class="col-xs-2 pull-right">
                <h5>
                    <strong>
                        VISA CAISSE
                    </strong>
                </h5>
            </div>

        </div> --}}
        {{-- <div class="row" id="test2" style="margin-top: 60px">
            <div class="col-xs-3 pull-left">
                <h5>
                    <strong>
                        CAISSE
                    </strong>
                </h5>
            </div>

            <div class="col-xs-3 text-center">
                <h5>
                    <strong>
                        COMPTA
                    </strong>
                </h5>
            </div>

            <div class="col-xs-3 pull-right">
                <h5>
                    <strong>
                        COMPTA
                    </strong>
                </h5>
            </div>

        </div> --}}

    </div>


</body>
</html>
