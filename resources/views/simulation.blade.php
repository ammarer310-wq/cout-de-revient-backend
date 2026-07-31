@extends('layouts.app')

@section('content')

<h2>Simulateur</h2>

<label>Prix de vente</label>

<input
    type="number"
    id="prix_vente"
>

<br><br>

<label>Volume produit</label>

<input
    type="number"
    id="volume"
>

<br><br>

<button onclick="simuler()">

    Simuler

</button>

<div id="resultat">

</div>

@endsection

<script>

function simuler()
{
    let prix =
        document
        .getElementById(
            'prix_vente'
        ).value;

    let volume =
        document
        .getElementById(
            'volume'
        ).value;

    fetch(
        '/api/simulation',
        {
            method:'POST',

            headers:
            {
                'Content-Type':
                    'application/json',

                'X-CSRF-TOKEN':
                    '{{ csrf_token() }}'
            },

            body:
                JSON.stringify({

                    prix_vente:
                        prix,

                    volume:
                        volume
                })
        }
    )
    .then(
        response =>
            response.json()
    )
    .then(data => {

        document
        .getElementById(
            'resultat'
        )
        .innerHTML =

        `
        Coût : ${data.cout}

        <br>

        Bénéfice unité :
        ${data.benefice_unitaire}

        <br>

        Bénéfice total :
        ${data.benefice_total}
        `;
    });
}

</script>

<table>

<tr>
    <th>Scénario</th>
    <th>Profit</th>
</tr>

<tbody id="tableScenarios">

</tbody>

</table>