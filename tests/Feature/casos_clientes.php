<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use app\Models\User;

class casos_clientes extends TestCase
{
     @return void

    public function casos_clientes()
    {
        $cliente = new User;
        $this->assertInstanceOf(Collection::class, $cliente->posts);
        $response = $this->get('resources\js\components\modulos\cuentas');
        if($response){
            $response->assertStatus(200);
        }else
            $response->assertStatus(406);
    }
}


