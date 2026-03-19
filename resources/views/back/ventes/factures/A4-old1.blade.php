<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Facture professionnelle</title>
    <style>
        /* RESET SIMPLE */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'DejaVu Sans', 'Helvetica', 'Arial', sans-serif;
            background: #f5f5f5;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            padding: 30px;
        }
        
        /* CONTENEUR PRINCIPAL */
        .invoice {
            max-width: 900px;
            margin: 0 auto;
            background: #ffffff;
            border: 1px solid #e0e0e0;
        }
        
        /* EN-TÊTE */
        .header {
            background: #2c3e50;
            color: white;
            padding: 25px 30px;
            border-bottom: 3px solid #e74c3c;
            overflow: hidden;
        }
        
        .header-left {
            float: left;
            width: 60%;
        }
        
        .header-left h1 {
            font-size: 32px;
            margin: 0 0 5px 0;
            font-weight: 700;
        }
        
        .header-left .slogan {
            font-size: 14px;
            color: #ecf0f1;
            font-style: italic;
        }
        
        .header-right {
            float: right;
            width: 40%;
            text-align: right;
        }
        
        .header-right h2 {
            font-size: 28px;
            margin: 0 0 10px 0;
            color: #e74c3c;
            font-weight: 700;
        }
        
        .header-right p {
            margin: 3px 0;
            color: #ecf0f1;
        }
        
        .header-right strong {
            color: white;
        }
        
        /* INFOS SOCIÉTÉ */
        .company-info {
            background: #f8f9fa;
            padding: 15px 30px;
            border-bottom: 1px solid #dee2e6;
            display: table;
            width: 100%;
        }
        
        .company-info .col {
            display: table-cell;
            width: 33.33%;
            vertical-align: top;
        }
        
        .company-info p {
            margin: 3px 0;
            color: #495057;
        }
        
        /* SECTION CLIENT */
        .client-section {
            padding: 30px;
            width: 100%;
            display: table;
            border-collapse: separate;
            border-spacing: 20px 0;
        }
        
        .client-row {
            display: table-row;
        }
        
        .client-box {
            display: table-cell;
            width: 50%;
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            padding: 20px;
            vertical-align: top;
        }
        
        .client-box h3 {
            font-size: 16px;
            color: #2c3e50;
            margin: 0 0 15px 0;
            padding-bottom: 8px;
            border-bottom: 2px solid #e74c3c;
            text-transform: uppercase;
        }
        
        .client-box .name {
            font-size: 16px;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 10px;
        }
        
        .client-box p {
            margin: 5px 0;
            color: #495057;
        }
        
        /* TABLEAU PRINCIPAL */
        .table-container {
            padding: 0 30px 30px 30px;
        }
        
        .main-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .main-table th {
            background: #34495e;
            color: white;
            font-weight: 600;
            padding: 12px 8px;
            text-align: left;
            font-size: 12px;
            text-transform: uppercase;
            border: 1px solid #2c3e50;
        }
        
        .main-table td {
            padding: 10px 8px;
            border: 1px solid #dee2e6;
        }
        
        .main-table tr:last-child td {
            border-bottom: 2px solid #34495e;
        }
        
        .product-desc {
            font-weight: 600;
            color: #2c3e50;
        }
        
        .product-ref {
            font-size: 10px;
            color: #6c757d;
            margin-top: 3px;
        }
        
        .badge {
            background: #e74c3c;
            color: white;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 11px;
            font-weight: 600;
            display: inline-block;
        }
        
        /* TOTAUX - VERSION TABLEAU ALIGNÉ À DROITE SANS DÉBORDEMENT */
        .totals-section {
            padding: 0 30px 30px 30px;
            width: 100%;
            text-align: right;
        }
        
        .totals-table {
            width: 320px; /* Réduit à 320px pour être sûr de rester dans les limites */
            border-collapse: collapse;
            margin-left: auto;
            margin-right: 0;
            border: 1px solid #dee2e6;
            font-size: 12px;
        }
        
        .totals-table td {
            padding: 10px 12px; /* Réduit légèrement le padding */
            border: none;
            border-bottom: 1px dashed #ced4da;
        }
        
        .totals-table tr:last-child td {
            border-bottom: none;
        }
        
        .totals-table .label-cell {
            text-align: left;
            font-weight: normal;
            color: #495057;
        }
        
        .totals-table .value-cell {
            text-align: right;
            font-weight: 600;
            color: #2c3e50;
        }
        
        .totals-table .grand-total-row {
            background: #e74c3c;
        }
        
        .totals-table .grand-total-row td {
            padding: 12px; /* Padding uniforme */
            border-bottom: none;
        }
        
        .totals-table .grand-total-row .label-cell {
            color: white;
            font-weight: 600;
            font-size: 14px;
        }
        
        .totals-table .grand-total-row .value-cell {
            color: white;
            font-weight: 700;
            font-size: 16px;
        }
        
        /* PAIEMENT */
        .payment-section {
            background: #f8f9fa;
            padding: 20px 30px;
            border-top: 1px solid #dee2e6;
            border-bottom: 1px solid #dee2e6;
            overflow: hidden;
        }
        
        .payment-info {
            float: left;
            width: 60%;
        }
        
        .payment-info h4 {
            font-size: 14px;
            color: #2c3e50;
            margin: 0 0 10px 0;
            text-transform: uppercase;
        }
        
        .bank-details {
            background: white;
            border: 1px solid #dee2e6;
            padding: 10px;
            font-family: monospace;
            margin-bottom: 10px;
        }
        
        .due-box {
            float: right;
            width: 35%;
            background: white;
            border: 1px solid #dee2e6;
            padding: 15px;
            text-align: center;
        }
        
        .due-label {
            font-size: 11px;
            color: #6c757d;
            text-transform: uppercase;
        }
        
        .due-date {
            font-size: 20px;
            font-weight: 700;
            color: #e74c3c;
            margin: 5px 0;
        }
        
        .status {
            display: inline-block;
            padding: 4px 12px;
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            font-size: 11px;
            font-weight: 600;
            border-radius: 3px;
        }
        
        .status-paid {
            background: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
        }
        
        /* FOOTER */
        .footer {
            background: #2c3e50;
            color: #ecf0f1;
            padding: 15px 30px;
            overflow: hidden;
        }
        
        .footer-left {
            float: left;
            width: 70%;
        }
        
        .footer-right {
            float: right;
            width: 30%;
            text-align: right;
        }
        
        .footer p {
            margin: 3px 0;
            font-size: 10px;
        }
        
        .stamp {
            font-family: cursive;
            color: #e74c3c;
            margin-top: 5px;
        }
        
        /* UTILITAIRES */
        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        /* IMPRESSION */
        @media print {
            body {
                background: white;
                padding: 0;
            }
            .invoice {
                border: none;
            }
            .main-table th {
                background: #34495e !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .totals-table .grand-total-row {
                background: #e74c3c !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .badge {
                background: #e74c3c !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>
    <div class="invoice">
        
        <!-- HEADER -->
        <div class="header clearfix">
            <div class="header-left">
                <h1>ENTREPRISE SAS</h1>
                <div class="slogan">Expertise & Conseil</div>
            </div>
            <div class="header-right">
                <h2>FACTURE</h2>
                <p><strong>N° FACT-2024-001</strong></p>
                <p>01/03/2024</p>
            </div>
        </div>
        
        <!-- COMPANY INFO -->
        <div class="company-info">
            <div class="col">
                <p>📍 123 Rue du Commerce</p>
                <p>📞 01 23 45 67 89</p>
            </div>
            <div class="col">
                <p>✉ contact@entreprise.fr</p>
                <p>🏢 SIRET: 123 456 789 00012</p>
            </div>
            <div class="col">
                <p>🔑 TVA: FR12345678901</p>
                <p>📅 RCS: 123 456 789</p>
            </div>
        </div>
        
        <!-- CLIENT -->
        <div class="client-section">
            <div class="client-row">
                <div class="client-box">
                    <h3>Facturer à</h3>
                    <p class="name">CLIENT PROFESSIONNEL</p>
                    <p>Service Comptabilité</p>
                    <p>456 Avenue des Entreprises</p>
                    <p>69002 Lyon</p>
                    <p>comptabilite@client.fr</p>
                    <p>TVA: FR987654321</p>
                </div>
                <div class="client-box">
                    <h3>Livrer à</h3>
                    <p class="name">CLIENT PROFESSIONNEL</p>
                    <p>Service Technique</p>
                    <p>456 Avenue des Entreprises</p>
                    <p>69002 Lyon</p>
                    <p>technique@client.fr</p>
                    <p>04 78 90 12 34</p>
                </div>
            </div>
        </div>
        
        <!-- TABLEAU PRINCIPAL -->
        <div class="table-container">
            <table class="main-table">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Qté</th>
                        <th>Prix unitaire</th>
                        <th>TVA</th>
                        <th>Total HT</th>
                        <th>Total TTC</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="product-desc">Développement site e-commerce</div>
                            <div class="product-ref">Réf: DEV-2024-001</div>
                        </td>
                        <td class="text-center"><span class="badge">1</span></td>
                        <td class="text-right">2 500,00 €</td>
                        <td class="text-center">20%</td>
                        <td class="text-right">2 500,00 €</td>
                        <td class="text-right"><strong>3 000,00 €</strong></td>
                    </tr>
                    <tr>
                        <td>
                            <div class="product-desc">Hébergement premium - Annuel</div>
                            <div class="product-ref">Réf: HEB-2024</div>
                        </td>
                        <td class="text-center"><span class="badge">12</span></td>
                        <td class="text-right">50,00 €</td>
                        <td class="text-center">20%</td>
                        <td class="text-right">600,00 €</td>
                        <td class="text-right"><strong>720,00 €</strong></td>
                    </tr>
                    <tr>
                        <td>
                            <div class="product-desc">Maintenance prioritaire</div>
                            <div class="product-ref">Réf: MAINT-2024</div>
                        </td>
                        <td class="text-center"><span class="badge">1</span></td>
                        <td class="text-right">800,00 €</td>
                        <td class="text-center">20%</td>
                        <td class="text-right">800,00 €</td>
                        <td class="text-right"><strong>960,00 €</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <!-- TOTAUX - VERSION TABLEAU ALIGNÉ À DROITE SANS DÉBORDEMENT -->
        <div class="totals-section">
            <table class="totals-table">
                <tr>
                    <td class="label-cell">Sous-total HT :</td>
                    <td class="value-cell">3 900,00 €</td>
                </tr>
                <tr>
                    <td class="label-cell">TVA 20% :</td>
                    <td class="value-cell">780,00 €</td>
                </tr>
                <tr>
                    <td class="label-cell">Total TTC :</td>
                    <td class="value-cell">4 680,00 €</td>
                </tr>
                <tr class="grand-total-row">
                    <td class="label-cell">Net à payer :</td>
                    <td class="value-cell">4 680,00 €</td>
                </tr>
            </table>
        </div>
        
        <!-- PAIEMENT -->
        <div class="payment-section clearfix">
            <div class="payment-info">
                <h4>Coordonnées bancaires</h4>
                <div class="bank-details">
                    IBAN: FR76 1234 5678 9012 3456 7890 123<br>
                    BIC: CRLYFRPP
                </div>
                <p style="color: #6c757d; font-size: 10px;">
                    * Pénalité de retard : 3 fois le taux d'intérêt légal
                </p>
            </div>
            <div class="due-box">
                <div class="due-label">Échéance</div>
                <div class="due-date">15/03/2024</div>
                <div class="status">Non payée</div>
            </div>
        </div>
        
        <!-- FOOTER -->
        <div class="footer clearfix">
            <div class="footer-left">
                <p>SARL au capital de 50 000 € - RCS Paris 123 456 789</p>
                <p>Code APE : 7022Z - TVA intra: FR12345678901</p>
            </div>
            <div class="footer-right">
                <p>Cachet & signature</p>
                <div class="stamp">Pour ENTREPRISE SAS</div>
            </div>
        </div>
        
    </div>
</body>
</html>