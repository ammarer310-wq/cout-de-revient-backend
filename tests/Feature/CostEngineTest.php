<?php

namespace Tests\Feature;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CostEngineTest extends TestCase
{
    /**
     * A basic feature test example.
     */
   public function test_calcul_cout()
{
    $cout =

        4.66
        +
        2
        +
        1
        +
        0.5;

    $this->assertEquals(

        8.16,

        round($cout,2)
    );
}
}
