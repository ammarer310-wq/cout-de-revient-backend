import Chart from 'chart.js/auto';
window.Chart = Chart;

import './bootstrap';
import Chart from 'chart.js/auto';

document.addEventListener('DOMContentLoaded', () => {

    const ctx = document.getElementById('coutChart');

    if(ctx){

        new Chart(ctx,{
            type:'bar',

            data:{
                labels:[
                    'Produit A',
                    'Produit B',
                    'Produit C'
                ],

                datasets:[{
                    label:'Coût',

                    data:[
                        120,
                        90,
                        150
                    ]
                }]
            }
        });

    }

});