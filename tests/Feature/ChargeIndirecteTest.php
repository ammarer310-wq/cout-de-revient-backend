<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\ChargeIndirecte;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ChargeIndirecteTest extends TestCase
{
    use RefreshDatabase;

    public function test_creation_charge()
    {
        $response = $this->postJson(
            '/api/chargesindirectes',
            [
                'nom'=>'Electricité',
                'montant'=>1000,
                'methode_repartition'=>'temps'
            ]
        );

        $response->assertStatus(201);
    }
}