<?php

namespace Tests\Unit;

use Tests\TestCase;

class AlbumTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->assertTrue(true);
    }

    public function test_albumListAvalibility(){
        $response = $this->get('/login');
        $response->assertOk();
    }

}
