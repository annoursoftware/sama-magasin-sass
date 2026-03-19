<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8"/>
    <title>Recouvrements | Créances</title>

    {{-- Bootstrap --}}
    <link rel="stylesheet" href="{{ public_path('bootstrap.min.css') }}">

    {{-- Google Fonts --}}
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Josefin+Slab" />

    <style>
        body {
            text-align: justify;
            text-justify: inter-word;
            font-family: "Josefin Slab";
            font-size: 24px;
            font-weight: 700;
            line-height: 26.4px;
        }
        h3, h5, p, li, pre, blockquote {
            font-family: "Josefin Slab";
        }
        h3 { font-size: 14px; font-weight: 700; }
        h5 { font-size: 14px; font-weight: 700; }
        p  { font-size: 14px; font-weight: 400; line-height: 20px; }
        li, pre { font-size: 13px; font-weight: 400; }
        blockquote { font-size: 21px; font-weight: 400; line-height: 30px; }

        .small-text { font-size: x-small; }
        .xsmall-text { font-size: xx-small; }
        .margin-top-5 { margin-top: 5px; }
        .margin-top-30 { margin-top: 30px; }
        .margin-top-15 { margin-top: 15px; }

        hr {
            border: 1px outset #f7f7f7;
            margin: 12px;
        }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            height: 50px;
            color: #4b646f;
        }
        .page-break { page-break-after: always; }
    </style>
</head>
<body>
    <div class="container margin-top-5">

        {{-- Logo --}}
        <div class="row">
            <div class="col-xs-3">
                <h3 class="text-uppercase">
                    Sama-Magasin
                    {{-- <img src="{{ asset('upload/logo/'.$parametrage->logo) }}" width="150" height="60" alt="Logo"> --}}
                </h3>
            </div>

            <div class="col-xs-3 pull-right" style="border: 3px solid tomato; padding: 5px; border-radius: 5px">
                <h3 class="text-uppercase text-center">
                    Créances
                </h3>
            </div>
        </div>

        {{-- Tableau des résultats --}}
        <div class="row margin-top-30">
            <div class="col-xs-12">
                <table class="table table-bordered">
                    <thead class="small-text" style="background-color: #D3D3D3">
                        <tr>
                            <th class="text-center">#</th>
                            <th>Contrat</th>
                            <th>Client</th>
                            <th class="text-center">Production</th>
                            <th class="text-center">Encaissements</th>
                            <th class="text-center">Restant</th>
                        </tr>
                    </thead>
                    <tbody class="xsmall-text">
                        @forelse($resultat as $i => $r)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $r->num_contrat }}</td>
                                <td>{{ $r->client }}</td>
                                <td class="text-center">{{ number_format(($r->montant) , 0, ",",".")}} FCFA</td>
                                <td class="text-center">{{ number_format(($r->montant_encaisse) , 0, ",",".")}} FCFA</td>
                                <td class="text-center">{{ number_format(($r->montant_restant_a_encaisser) , 0, ",",".")}} FCFA</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Aucun Impayé à cette période</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Totaux --}}
        <div class="row small-text" style="margin-top: 7px">
            <div class="col-xs-5 pull-left">
                <table class="table table-bordered">
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

        {{-- Date --}}
        <div class="row" id="test" style="margin-top: 15px">
            <div class="col-xs-3 pull-left">
                <h5><strong>Fait à Dakar, le {{ now()->format('d/m/Y') }}</strong></h5>
            </div>
        </div>

    </div>
</body>
</html>
