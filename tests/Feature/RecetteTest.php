<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RecetteTest extends TestCase
{
    public function test_calcul_perte(): void
    {
        $quantite = 500;
        $perte = 5;

        $resultat = $quantite * (1 + $perte / 100);

        $this->assertEquals(525, $resultat);
    }

    public function test_calcul_rendement(): void
    {
        $quantite = 525;
        $rendement = 90;

        $resultat = $quantite / ($rendement / 100);

        $this->assertEquals(583.33, round($resultat, 2));
    }

    public function test_calcul_quantite_reelle(): void
    {
        $quantite = 500;
        $perte = 5;
        $rendement = 90;

        $resultat = ($quantite * (1 + $perte / 100)) / ($rendement / 100);

        $this->assertEquals(583.33, round($resultat, 2));
    }
}
