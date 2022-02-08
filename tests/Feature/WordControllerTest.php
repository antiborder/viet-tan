<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WordControllerTest extends TestCase
{
    use RefreshDatabase;
    
    public function testIndex()
    {
        // $response = $this->get(route('words.index'));

        // $response->assertStatus(200)
        //     ->assertViewIs('words.index');
    }
}
