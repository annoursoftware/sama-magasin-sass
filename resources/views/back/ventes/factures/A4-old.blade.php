<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Facture {{ $vente->num_vente }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; margin: 30px; color: #333; }
        h2, h3 { margin: 0; }

        /* Bloc entreprise à gauche */
        .company {
            display: inline-block;
            width: 55%;
            vertical-align: top;
        }
        .company h2 { color: #2c3e50; }

        /* Bloc Facture N° en haut à droite */
        .facture-num-devis {
            float: right;
            border: 1px solid #8e2430;
            padding: 10px;
            background-color: #fdf2f4;
            border-radius: 6px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.15);
            width: 230px;
            text-align: center;
        }
        .facture-num-facture {
            float: right;
            border: 1px solid #1d9181;
            padding: 10px;
            background-color: #aae8eb;
            border-radius: 6px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.15);
            width: 230px;
            text-align: center;
        }

        /* Bloc client après entreprise mais à droite */
        .client-box-devis {
            border: 1px solid #8e2430;
            padding: 12px;
            background-color: #fdf2f4;
            border-radius: 6px;
            width: 250px;
            margin-left: auto;   /* pousse à droite */
            margin-top: 10px;    /* espace après entreprise */
            box-shadow: 0 2px 6px rgba(0,0,0,0.15);

            width: 300px;       /* largeur limitée comme client-box */
            margin-left: auto;  /* pousse le bloc à droite */
        }
        
        .client-box-facture {
            border: 1px solid #1d9181;
            padding: 12px;
            background-color: #aae8eb;
            border-radius: 6px;
            width: 250px;
            margin-left: auto;   /* pousse à droite */
            margin-top: 10px;    /* espace après entreprise */
            box-shadow: 0 2px 6px rgba(0,0,0,0.15);
            
            width: 300px;       /* largeur limitée comme client-box */
            margin-left: auto;  /* pousse le bloc à droite */
        }

        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background-color: #f2f2f2; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }

        .totaux-devis {
            text-align: right;
            margin-top: 20px;
            font-size: 14px;
            font-weight: bold;
            border: 1px solid #8e2430;
            background-color: #fdf2f4;
            padding: 12px;
            border-radius: 6px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);

            width: 300px;       /* largeur limitée comme client-box */
            margin-left: auto;  /* pousse le bloc à droite */
        }
        .totaux-devis p {
            margin: 5px 0;
        }

        .totaux-facture {
            text-align: right;
            margin-top: 20px;
            font-size: 14px;
            font-weight: bold;
            border: 1px solid #1d9181;
            background-color: #aae8eb;
            padding: 12px;
            border-radius: 6px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);

            width: 300px;       /* largeur limitée comme client-box */
            margin-left: auto;  /* pousse le bloc à droite */
        }
        .totaux-facture p { margin: 5px 0; }

        .notes-facture { margin-top: 30px; font-size: 11px; background: #aae8eb; padding: 10px; border: 1px solid #1d9181; border-radius: 6px; }
        .notes-devis { margin-top: 30px; font-size: 11px; background: #fdf2f4; padding: 10px; border: 1px solid #8e2430; border-radius: 6px; }

        footer { position: fixed; bottom: 0; left: 0; right: 0; text-align: center; font-size: 10px; color: #555; }
        footer hr { margin-bottom: 5px; border: none; border-top: 1px solid #ccc; }
    </style>
</head>
<body>
    <!-- Bloc Facture N° en haut à droite -->
    <div class="{{ $vente->status_vente == 'f' ? 'facture-num-facture' : 'facture-num-devis' }}">
        <h3>
            {{ $vente->status_vente == 'f' 
                ? 'Facture N° ' . $vente->num_vente . '-' . \Carbon\Carbon::parse($vente->created_at)->format('m-Y') 
                : 'Devis N° ' . $vente->num_vente . '-' . \Carbon\Carbon::parse($vente->created_at)->format('m-Y') }}
        </h3>
    </div>


    <!-- Bloc entreprise à gauche -->
    <div class="company">
        <img src="{{ public_path('Sama-Magasin.png') }}" alt="Logo" style="height:60px; margin-bottom:10px;">
        {{-- <h2>{{ config('app.name') }}</h2> --}}
        <p>
            Soprim, PA U22<br>
            Téléphone : +221 77 000 00 00<br>
            Email : contact@entreprise.com
        </p>
    </div>

    <!-- Bloc client après entreprise mais à droite -->
    <div class="{{ $vente->status_vente == 'f' ? 'client-box-facture' : 'client-box-devis' }}">
        <p><strong>Client :</strong> {{ $vente->client }}</p>
        <p><strong>Adresse :</strong> {{ $vente->adresse }}</p>
        <p><strong>Téléphone :</strong> {{ $vente->telephone_primaire }}</p>
        <p><strong>Date :</strong> {{ \Carbon\Carbon::parse($vente->created_at)->format('d/m/Y') }}</p>
    </div>

    <!-- Tableau des articles -->
    <table>
        <thead>
            <tr>
                <th width="45%">Article</th>
                <th width="7%">Quantité</th>
                <th>Prix Unitaire</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ventes as $item)
                <tr>
                    <td>{{ $item->article }}</td>
                    <td>{{ $item->quantite }}</td>
                    <td>{{ number_format($item->montant, 0, ',', ' ') }}</td>
                    <td>{{ number_format($item->montant * $item->quantite, 0, ',', ' ') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Totaux -->
    <div class="{{ $vente->status_vente == 'f' ? 'totaux-facture' : 'totaux-devis' }}">
        <h4>
            {{ $vente->status_vente == 'f' ? 'Totaux Facture' : 'Totaux Devis' }}
        </h4>
        <p>Montant total : {{ number_format($vente->montant, 0, ',', ' ') }} F CFA</p>
        <p>Encaissement : {{ number_format($vente->montant, 0, ',', ' ') }} F CFA</p>
        <p>Restant : {{ number_format($vente->montant, 0, ',', ' ') }} F CFA</p>
    </div>


    <!-- Notes -->
    <div class="{{ $vente->status_vente == 'f' ? 'notes-facture' : 'notes-devis' }}">
        <h4>Conditions de paiement</h4>
        <p>
            Règlement attendu sous 15 jours à compter de la date de facture.<br>
            Modes de paiement acceptés : espèces, virement bancaire, mobile money.
        </p>

        <h4>Notes</h4>
        <p>
            Merci de vérifier les articles à la réception.<br>
            Pour toute réclamation, contactez notre service client au +221 77 000 00 00.
        </p>
    </div>

    <!-- Pied de page -->
    <footer>
        <hr>
        <p>Merci pour votre confiance</p>
        <p>{{ config('app.name') }}</p>
    </footer>
</body>
</html>
