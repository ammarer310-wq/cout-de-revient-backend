<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #2E2118; }
        h1 { color: #C08B2C; border-bottom: 2px solid #E5DCCF; padding-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #E5DCCF; padding: 8px; text-align: left; }
        th { background-color: #FAF6F0; }
        .rentable-oui { color: #5C7A4A; font-weight: bold; }
        .rentable-non { color: #A33B2C; font-weight: bold; }
    </style>
</head>
<body>
    <h1>Rapport de coûts de revient</h1>
    <p>Généré le {{ date('d/m/Y à H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>Produit</th>
                <th>Coût total</th>
                <th>Prix de vente</th>
                <th>Rentable</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($produits as $produit)
                <tr>
                    <td>{{ $produit['nom'] }}</td>
                    <td>{{ $produit['cout_total'] ?? '—' }} dh</td>
                    <td>{{ $produit['prix_vente'] ?? '—' }} dh</td>
                    <td class="{{ $produit['rentable'] ? 'rentable-oui' : 'rentable-non' }}">
                        @if ($produit['rentable'] === true)
                            Oui
                        @elseif ($produit['rentable'] === false)
                            Non
                        @else
                            —
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>